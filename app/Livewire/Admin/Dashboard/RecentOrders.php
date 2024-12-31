<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Order;
use Livewire\Component;

class RecentOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        // Lấy 10 đơn hàng gần đây, sắp xếp theo thời gian tạo giảm dần
        $this->orders = Order::with('user') // Nếu có mối quan hệ khách hàng
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.recent-orders');
    }
}
