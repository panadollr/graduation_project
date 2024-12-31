<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddToCartAndBuyNow extends Component
{
    public $productId;
    public $quantity = 1; // Default quantity to 1
    public $isInCart = false;

    public function mount($productId, $quantity = 1)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->isInCart = Cart::where('product_id', $productId)->where('user_id', Auth::id())->exists();
    }

    public function toggleCart()
    {
        // Kiểm tra xem sản phẩm đã có trong giỏ hay chưa
        $cartItem = Cart::where('product_id', $this->productId)
        ->where('user_id', Auth::id())
        ->first();

        if ($cartItem) {
        // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên theo số lượng mới
        $cartItem->update([
        'quantity' => $cartItem->quantity + $this->quantity
        ]);
        } else {
        // Nếu sản phẩm chưa có trong giỏ, tạo mới giỏ hàng
        Cart::create([
        'product_id' => $this->productId,
        'user_id' => Auth::id(),
        'quantity' => $this->quantity
        ]);
        }

        $this->isInCart = true;
        $this->js("toastr.success('Đã thêm sản phẩm vào giỏ hàng!')");
    }

    public function buyNow()
    {
        $checkoutProducts = [['product_id' => $this->productId, 'quantity' => $this->quantity]];
        return redirect()->route('checkout.index', ['checkoutProducts' => $checkoutProducts]);
    }

    public function render()
    {
        return view('livewire.client.add-to-cart-and-buy-now');
    }
}
