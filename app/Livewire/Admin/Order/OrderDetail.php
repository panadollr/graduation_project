<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

class OrderDetail extends Component
{
   
    public Order $order;

    public function mount($id)
    {
        $this->order = Order::with([
            'items', 
            'orderStatusHistories' => function($query) {
                $query->orderBy('changed_at');
            }
        ])
        ->findOrFail($id);    
    }

   
    #[Title('Chi tiết đơn hàng')] 
    public function render()
    {
        return view('livewire.admin.order.order-detail')
        ->extends('admin.app')
       ;
    }
}
