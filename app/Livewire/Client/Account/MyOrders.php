<?php

namespace App\Livewire\Client\Account;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyOrders extends Component
{
    public $orders = [];           // Danh sách đơn hàng
    public $searchTerm = '';
    public $filter = 'all';        // Bộ lọc trạng thái ('all', 'pending', 'shipping', v.v.)
    public $selectedOrderId;       // ID đơn hàng được chọn
    public $isCancelModalOpen = false; // Trạng thái mở modal hủy đơn hàng

    // Khởi tạo và tải đơn hàng
    public function mount()
    {
        $this->loadOrders();
    }

    // Tải danh sách đơn hàng dựa trên trạng thái lọc
    public function loadOrders()
    {
        $query = Order::where('user_id', Auth::id())->with('items.product');;

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        if ($this->searchTerm) {
            $query->where(function ($query) {
                $query->where('id', 'like', '%' . $this->searchTerm . '%')
                      ->orWhereHas('items.product', function($q) {
                          $q->where('name', 'like', '%' . $this->searchTerm . '%');
                      });
            });
        }

        $this->orders = $query->orderBy('created_at', 'desc')->get();
    }

    // Lọc đơn hàng khi người dùng chọn tab
    public function filterOrders($status)
    {
        $this->filter = $status;
        $this->loadOrders();
    }

    // Mở modal xác nhận hủy đơn hàng
    public function openCancelModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->isCancelModalOpen = true;
    }

    // Đóng modal hủy đơn hàng
    public function closeCancelModal()
    {
        $this->isCancelModalOpen = false;
        $this->selectedOrderId = null;
    }

    // Hủy đơn hàng
    public function cancelOrder()
    {
        $order = Order::findOrFail($this->selectedOrderId);

        if ($order->status === 'pending') {
            // Duyệt qua từng mục sản phẩm trong đơn hàng và hoàn lại số lượng hàng
            foreach ($order->items as $item) {
                $product = $item->product; // Lấy sản phẩm tương ứng
                $product->releaseStock($item->quantity); // Gọi hàm hoàn lại số lượng
            }

            if ($order->discount) {
                $discount = $order->discount;
                $discount->decrement('used_count');
            }

            $order->update(['status' => 'cancelled']);
            $this->js("toastr.success('Đơn hàng đã được hủy thành công.')");
        } 

        $this->closeCancelModal();
        $this->loadOrders();
    }

    public function updatedSearchTerm()
    {
        $this->loadOrders();
    }


    // Render view
    public function render()
    {
        return view('livewire.client.account.my-orders', [
            'orders' => $this->orders,
        ])
        ->extends('client.account.layout')
        ->section('main')
        ->layoutData(['title' => 'Đơn hàng của tôi']);
    }
}
