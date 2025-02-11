<?php

namespace App\Livewire\Client;

use App\Mail\SuccessOrderMail;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Services\VNPayService;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CheckoutForm extends Component
{
    public $addresses;
    public $checkoutProducts;
    public $shippingMethods;
    public $selectedShipping;
    public $selectedAddress;
    public $selectedPaymentMethod = 'cod';
    public $note;
    public $discounts = [];
    public $discountCode; // Mã giảm giá người dùng nhập
    public $appliedDiscount = null; // Thông tin mã giảm giá đã áp dụng
    public $subTotal;
    public $estimatedTotal;

    public function mount($addresses, $checkoutProducts, $shippingMethods)
    {
        $this->addresses = $addresses;
        $this->checkoutProducts = $checkoutProducts;
        $this->shippingMethods = $shippingMethods;
        $this->selectedShipping = $shippingMethods[0]->id ?? null; // Mặc định chọn phương thức đầu tiên
        $defaultAddress = $addresses->firstWhere('is_default', true);
        $this->selectedAddress = $defaultAddress ? $defaultAddress->id : null;
        $this->discounts = Discount::where('status', true)
            ->where('end_date', '>', now())
            ->get();
        $this->updateTotal();
    }

    protected $middleware = [
        \App\Http\Middleware\ReadOnlyDatabase::class,
    ];

    public function updatedSelectedShipping()
    {
        $this->updateTotal();
    }

    private function updateTotal()
    {
        $shippingPrice = $this->shippingMethods->firstWhere('id', $this->selectedShipping)->price ?? 0;
        $this->subTotal = $this->checkoutProducts->sum(function ($product) {
            return $product['sale_price'] * $product['quantity'];
        }) + $shippingPrice;
        $this->estimatedTotal = $this->subTotal;

        // Nếu đã áp dụng mã giảm giá, tính lại estimatedTotal
        if ($this->appliedDiscount) {
            $discountValue = $this->subTotal * ($this->appliedDiscount->discount_value / 100);
            $this->estimatedTotal -= $discountValue;
        }
    }

    private function clearCart()
    {
        Cart::where('user_id', auth()->id())->delete();
        $this->checkoutProducts = collect();
    }

    public function applyDiscount()
    {
        // Tìm mã giảm giá
        $discount = Discount::where('code', $this->discountCode)
            ->where('status', 1)
            ->first();

        // Kiểm tra mã giảm giá hợp lệ
        if (!$discount || !$discount->isValid()) {
            $this->js("toastr.error('Mã giảm giá không hợp lệ hoặc đã hết hạn!')");
            return;
        }

        // Kiểm tra điều kiện đơn hàng tối thiểu
        if ($discount->min_order_value && $this->subTotal < $discount->min_order_value) {
            $this->js("toastr.error('Đơn hàng không đủ giá trị tối thiểu để áp dụng mã giảm giá!')");
            return;
        }

        // Lưu mã giảm giá đã áp dụng
        $this->appliedDiscount = $discount;

        // Tính lại tổng tiền ước tính với giảm giá
        $discountValue =  $this->subTotal * ($this->appliedDiscount->discount_value / 100);
        $this->estimatedTotal = $this->subTotal - $discountValue;

        $this->js("toastr.success('Áp dụng mã giảm giá thành công!')");
    }

    public function submitOrder($paymentMethod)
    {
        if ($this->addresses->isEmpty()) {
            $this->js("toastr.error('Bạn cần thêm ít nhất một địa chỉ để thanh toán!')");
            return;
        }

        $this->selectedPaymentMethod = $paymentMethod;
        $this->validateOrderData();

        // Kiểm tra tồn kho
        if ($this->hasOutOfStock()) {
            return; // Đã có lỗi, dừng lại
        }

        // Tạo đơn hàng
        $order = $this->createOrder();

        // Cập nhật kho và tạo chi tiết đơn hàng
        $this->processOrderItems($order);

        // Xử lý thanh toán
        if ($paymentMethod === 'cod') {
            return $this->processCODPayment();
        } elseif ($paymentMethod === 'vnpay') {
            return $this->processVNPAYPayment($order);
        }
    }

    private function showError($message)
    {
        $this->js("toastr.error('$message')");
    }

    private function validateOrderData()
    {
        $this->validate([
            'selectedAddress' => 'required|exists:user_addresses,id',
            'selectedShipping' => 'required|exists:shipping_methods,id',
            'selectedPaymentMethod' => 'required|in:cod,vnpay',
        ]);
    }

    private function hasOutOfStock()
    {
        foreach ($this->checkoutProducts as $checkoutProduct) {
            $product = Product::find($checkoutProduct['id']);
            if (!$product->isInStock($checkoutProduct['quantity'])) {
                $this->showError("Sản phẩm {$product->name} không đủ số lượng trong kho!");
                return true;
            }
        }
        return false;
    }

    private function createOrder()
    {
        return Order::create([
            'user_id' => auth()->id(),
            'total_price' => $this->estimatedTotal,
            'status' => 'pending',
            'shipping_method_id' => $this->selectedShipping,
            'payment_method' => $this->selectedPaymentMethod,
            'user_address_id' => $this->selectedAddress,
            'note' => $this->note,
            'discount_id' => $this->appliedDiscount ? $this->appliedDiscount->id : null,
        ]);
    }

    private function processOrderItems($order)
    {
        foreach ($this->checkoutProducts as $checkoutProduct) {
            $product = Product::find($checkoutProduct['id']);
            $product->reserveStock($checkoutProduct['quantity']); // Đặt trước sản phẩm trong kho

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $checkoutProduct['quantity'],
                'price' => $product->sale_price * $checkoutProduct['quantity'],
            ]);
        }

        if ($this->appliedDiscount) {
            $this->appliedDiscount->increment('used_count');
        }
        // $this->sendSuccessEmail($order);
        $this->clearCart();
        Log::logAction(auth()->id(), 'Đã đặt đơn hàng #' . $order->id);
        // Cập nhật trạng thái lịch sử
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'changed_by' => auth()->id(),
            'changed_at' => now(),
            'note' => 'Đơn hàng mới được tạo',
        ]);
    }

    private function processCODPayment()
    {
        return redirect()->route('checkout.success');
    }

    private function processVNPAYPayment($order)
    {
        $vnpayService = new VNPayService();
        $paymentUrl = $vnpayService->createPaymentUrl([
            'order_id' => $order->id,
            'amount' => $this->estimatedTotal,
            'locale' => 'vn',
            'description' => "Thanh toán đơn hàng ",
            'type' => 'billpayment',
        ]);

        return redirect($paymentUrl);
    }

    private function sendSuccessEmail($order)
    {
        $shippingMethod = $this->shippingMethods->firstWhere('id', $this->selectedShipping);
        $shippingFee = $shippingMethod ? $shippingMethod->price : 0;
        $discountValue = $this->appliedDiscount ? ($this->subTotal * ($this->appliedDiscount->discount_value / 100)) : 0;

        $dataMail = [
            'title' => 'Bạn đã xác nhận đơn hàng',
            'message' => 'Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi!',
            'order_id' => $order->id,
            'order_date' => now()->format('Y-m-d H:i:s'),
            'customer_name' => auth()->user()->name,
            'customer_phone' => auth()->user()->phone,
            'shipping_address' => $this->addresses->firstWhere('id', $this->selectedAddress)->address,
            'products' => array_map(function ($checkoutProduct) {
                $product = Product::find($checkoutProduct['id']);
                return [
                    'name' => $product->name,
                    'quantity' => $checkoutProduct['quantity'],
                    'price' => $product->sale_price * $checkoutProduct['quantity'],
                ];
            }, $this->checkoutProducts),
            'subtotal' => $this->estimatedTotal,
            'shipping_fee' => $shippingFee,
            'discount' => $discountValue,
            'total' => $this->estimatedTotal
        ];

        Mail::to(auth()->user()->email)->send(new SuccessOrderMail($dataMail));
    }


    public function render()
    {
        return view('livewire.client.checkout-form');
    }
}
