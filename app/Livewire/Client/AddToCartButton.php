<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddToCartButton extends Component
{
    public $productId;
    public $type;
    public $quantity = 1; // Default quantity to 1
    public $isInCart = false;

    public function mount($productId, $type = null, $quantity = 1)
    {
        $this->productId = $productId;
        $this->type = $type;
        $this->quantity = $quantity;
        $this->checkIfInCart();
    }

    public function checkIfInCart()
    {
        if (!Auth::check()) {
            $this->isInCart = false;
            return;
        }

        $this->isInCart = Cart::where('product_id', $this->productId)
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function toggleCart()
    {
        $cartItem = Cart::updateOrCreate(
            ['product_id' => $this->productId, 'user_id' => Auth::id()]
        );

        $cartItem->quantity = $cartItem->quantity + 1 ?? 1;
        $cartItem->save();

        $cartItem->product->reserveStock($cartItem->quantity); // Đặt trước sản phẩm trong kho

        $this->isInCart = true;
        $this->js("toastr.success('Đã thêm sản phẩm vào giỏ hàng!')");
        $this->dispatch('cartUpdated')->to(DropdownCart::class);;
    }

    public function render()
    {
        return view('livewire.client.add-to-cart-button');
    }
}
