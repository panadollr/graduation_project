<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        "user_id",
        "user_address_id",
        'shipping_method_id',
        "payment_method",
        "total_price",
        "status",
        "note",
        'discount_id',
      ];

    // Quan hệ với bảng User
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng UserAddress
    public function userAddress(){
        return $this->belongsTo(UserAddress::class);
    }

    // Quan hệ với bảng OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Quan hệ với bảng ShippingMethod
    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    // Mối quan hệ với mã giảm giá
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    // Mối quan hệ với bảng OrderStatusHistory
    public function orderStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    // Trả về mô tả trạng thái của đơn hàng
    public function getStatusString($status = null)
    {
        $status = $status ?? $this->status;
        $statusDescriptions = [
            'pending' => 'Đang chờ xác nhận',
            'shipped' => 'Đang giao hàng',
            'completed' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
        ];

        return $statusDescriptions[$status] ?? 'Chưa xác định';  // Trả về mặc định nếu không tìm thấy trạng thái
    }

    public function getPaymentMethod($payment_method = null)
    {
        $payment_method = $payment_method ?? $this->payment_method;
        $paymentMethodDescriptions = [
            'thanh-toan-khi-nhan-hang' => 'Thanh toán khi nhận hàng',
            'thanh-toan-vnpay' => 'Thanh toán trực tuyến qua VNPay',
        ];

        return $paymentMethodDescriptions[$payment_method] ?? 'Chưa xác định';
    }

    public function updateStatus($newStatus)
{
    // Lưu trạng thái cũ để xử lý tồn kho chính xác
    $oldStatus = $this->status;

    // Cập nhật trạng thái đơn hàng
    $this->status = $newStatus;
    $this->save();

    // Xử lý tồn kho dựa trên thay đổi trạng thái
    foreach ($this->items as $item) {
        $product = Product::find($item->product_id);
        if (!$product) {
            continue; // Bỏ qua nếu sản phẩm không tồn tại
        }
        
        switch ([$oldStatus, $newStatus]) {
            case ['pending', 'cancelled']: // Chuyển từ "chờ xác nhận" sang "hủy"
                $product->releaseStock($item->quantity);
                
                // Cập nhật lịch sử trạng thái đơn hàng
                OrderStatusHistory::create([
                    'order_id' => $this->id,
                    'status' => 'cancelled',
                    'changed_by' => auth()->id(),
                    'changed_at' => now(),
                    'note' => $this->getStatusChangeNote('cancelled'),
                ]);

                // Ghi lại log
                Log::logAction(auth()->id(), "Đã hủy đơn hàng #{$this->id}. Hệ thống đã hoàn trả lại số lượng tồn kho.");
                break;

            case ['pending', 'shipped']: // Chuyển từ "chờ xác nhận" sang "giao hàng"
                $product->confirmStock($item->quantity);
                // Cập nhật lịch sử trạng thái đơn hàng
                OrderStatusHistory::create([
                    'order_id' => $this->id,
                    'status' => 'shipped',
                    'changed_by' => auth()->id(),
                    'changed_at' => now(),
                    'note' => $this->getStatusChangeNote('shipped'),
                ]);

                // Ghi lại log
                Log::logAction(auth()->id(), "Đơn hàng #{$this->id} đã được xác nhận và chuyển sang trạng thái giao hàng.");
                break;

            case ['shipped', 'completed',]: // Chuyển từ "hoàn thành" sang "hủy" (nếu có rollback)
                $product->releaseStock($item->quantity);
                // Cập nhật lịch sử trạng thái đơn hàng
                OrderStatusHistory::create([
                    'order_id' => $this->id,
                    'status' => 'completed',
                    'changed_by' => auth()->id(),
                    'changed_at' => now(),
                    'note' => $this->getStatusChangeNote('completed'),
                ]);

                // Ghi lại log
                Log::logAction(auth()->id(), "Đơn hàng #{$this->id} đã được giao hàng thành công.");
                break;

            // Add more transitions if necessary
        }
    }
}

    private function getStatusChangeNote($status)
    {
            return match ($status) {
                'pending' => 'Đơn hàng đang chờ xử lý.',
                'shipped' => 'Đơn hàng đã được xác nhận và đang giao hàng.',
                'completed' => 'Đơn hàng đã hoàn thành.',
                'cancelled' => 'Đơn hàng đã bị hủy.',
                default => 'Trạng thái không xác định.',
            };
    }


}
