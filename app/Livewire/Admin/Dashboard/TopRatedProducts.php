<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Product;
use Livewire\Component;

class TopRatedProducts extends Component
{
    public $topProducts = [];
    public $sortType = 'high'; // Mặc định là đánh giá cao

    public function mount()
    {
        $this->loadTopProducts();
    }

    public function loadTopProducts()
    {
        $this->topProducts = Product::withAvg('reviews', 'rating') // Tính trung bình rating từ bảng reviews
        ->whereHas('reviews') // Chỉ lấy sản phẩm có ít nhất 1 đánh giá
        ->orderBy('reviews_avg_rating', $this->sortType === 'high' ? 'desc' : 'asc') // Sắp xếp theo đánh giá cao hoặc thấp
        ->take(10) // Lấy 10 sản phẩm
        ->get();
    }

    public function updateSort($type)
    {
        $this->sortType = $type;
        $this->loadTopProducts();
    }
    
    public function render()
    {
        return view('livewire.admin.dashboard.top-rated-products');
    }
}
