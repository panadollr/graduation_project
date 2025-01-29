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
    public $logs;

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
        $this->loadData();
    }

    public function loadData(){
        $this->quantity = $this->product->quantity;
        $this->sold_quantity = $this->product->sold_quantity;
        $this->stock = $this->product->getAvailableStock();
        // Lấy các logs có action liên quan đến nhập kho
        $this->logs = Log::where('action', 'like', '%Đã nhập kho cho sản phẩm có ID: ' . $this->product->id . '%')
                ->orderBy('created_at', 'desc')  // Sắp xếp theo thời gian mới nhất
                ->limit(10) // Lấy tối đa 10 bản ghi
                ->get();

        // Trích xuất số lượng nhập kho từ mỗi bản ghi log
        foreach ($this->logs as $log) {
            preg_match('/Số lượng nhập kho: (\d+)/', $log->action, $matches);
            $log->quantity_added = $matches[1] ?? null;  // Lấy số lượng từ câu log (nếu có)
        }
    }

    public function saveStock()
    {
        $this->product->quantity += $this->quantity_to_add;
        $this->product->quantity = $this->product->quantity - $this->product->sold_quantity;
        $this->product->stored_at = now();
        $this->product->save();
        $this->loadData();
        Log::logAction(Auth::id(), "Đã nhập kho cho sản phẩm có ID: {$this->product->id}, Số lượng nhập kho: {$this->quantity_to_add}");
        $this->js('showToast("Nhập số lượng thành công !", "success")');
    }
    
    public function render()
    {
        return view('livewire.admin.product.stock-form')
        ->extends('admin.app')
        ->layoutData(['title' => 'Nhập kho sản phẩm']);
    }
}
