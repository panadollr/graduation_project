<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $query = Cart::where('product_id', $this->productId);

        $this->isInCart = $query->where('user_id', Auth::id())->exists();
    }

    public function toggleCart()
    {
        $cartItem = Cart::updateOrCreate(
            ['product_id' => $this->productId, 'user_id' => Auth::id()],
            ['quantity' => 1]
        );

        $this->isInCart = true;
        $this->js("toastr.success('Đã thêm sản phẩm vào giỏ hàng!')");
    }

    public function render()
    {
        return view('livewire.client.add-to-cart-button');
    }
}
