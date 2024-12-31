<?php

namespace App\Livewire\Admin\Product;

use App\Models\Log;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditProductStock extends Component
{
    public $product, $quantity, $stock, $sold_quantity;
    public $quantity_to_add = 0;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
        $this->loadData();
    }

    public function loadData(){
        $this->quantity = $this->product->quantity;
        $this->sold_quantity = $this->product->sold_quantity;
        $this->stock = $this->product->getAvailableStock();
    }

    public function saveStock()
    {
        $this->product->quantity += $this->quantity_to_add;
        $this->product->stock = $this->product->quantity - $this->product->sold_quantity;
        $this->product->stored_at = now();
        $this->product->save();
        $this->loadData();
        Log::logAction(Auth::id(), "Đã nhập kho cho sản phẩm có ID: {$this->product->id}");
        $this->js('showToast("Nhập số lượng thành công !", "success")');
    }
    
    public function render()
    {
        return view('livewire.admin.product.stock-form')
        ->extends('admin.app')
        ->layoutData(['title' => 'Nhập kho sản phẩm']);
    }
}
