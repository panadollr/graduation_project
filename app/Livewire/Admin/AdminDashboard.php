<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboard extends Component
{
    public $totalProducts;
    public $totalOrders;
    public $totalUsers;

    public function mount()
    {
        // Lấy dữ liệu từ database
        $this->totalProducts = Product::count();
        $this->totalOrders = Order::count();
        $this->totalUsers = User::count();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard')
        ->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => 'Bảng điều khiển']);
    }
}
