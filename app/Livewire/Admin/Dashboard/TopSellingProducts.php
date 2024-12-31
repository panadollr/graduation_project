<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Product;
use Livewire\Component;

class TopSellingProducts extends Component
{
    public $topProducts = [];

    public function mount()
    {
        // Lấy danh sách 5 sản phẩm bán chạy nhất
        $this->topProducts = Product::withCount(['orderItems' => function($query) {
            $query->whereHas('order', function($orderQuery) {
                $orderQuery->where('status', 'completed'); // chỉ lấy đơn hàng hoàn thành
            });
        }])
        ->orderBy('order_items_count', 'desc') // Sắp xếp theo số lượng bán được
        ->take(5) // Lấy 5 sản phẩm bán chạy nhất
        ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.top-selling-products');
    }
}
