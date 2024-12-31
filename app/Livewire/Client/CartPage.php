<?php

namespace App\Livewire\Client;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        if (Auth::check()) {
            $this->cartItems = Cart::where('user_id', Auth::id())
                ->with('product') // Load product relationship
                ->get();

            $this->calculateTotal();
        }
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = Cart::find($cartItemId);
        if ($cartItem && $quantity > 0) {
            $cartItem->update(['quantity' => $quantity]);
        } else {
            $this->removeItem($cartItemId);
        }

        $this->refreshCart();
    }

    public function removeItem($cartItemId)
    {
        Cart::destroy($cartItemId);
        $this->refreshCart(); // Refresh the cart items
    }

    public function calculateTotal()
    {
        $items = $this->cartItems->map(function ($cartItem) {
            return [
                'price' => $cartItem->product->base_price,
                'quantity' => $cartItem->quantity,
            ];
        })->toArray();
    
        // Calculate total price using the helper
        $this->totalPrice = calculateTotalPrice($items, 'price', 'quantity');
    }

    public function render()
    {
        return view('livewire.client.cart-page');
    }
}
