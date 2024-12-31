<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropdownCart extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;

    public function mount()
    {
        if (Auth::check()) {
            $this->loadCart();
        }
    }

    public function loadCart()
    {
        $this->cartItems = Cart::where('user_id', Auth::id())
            ->with('product') 
            ->get();

        $this->totalPrice = 0;
        foreach ($this->cartItems as $cartItem) {
            $this->totalPrice += $cartItem->quantity * $cartItem->product->base_price;
        }
    }

    public function removeFromCart($cartItemId)
    {
        $cartItem = Cart::find($cartItemId);
        if ($cartItem && $cartItem->user_id == Auth::id()) {
            $cartItem->delete();
            $this->loadCart();
        }
    }

    public function render()
    {
        return view('livewire.client.dropdown-cart', [
            'cartItems' => $this->cartItems,
        ]);
    }
}
