<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\ProductReview;
use Livewire\Component;

class RecentReviews extends Component
{
    public $recentReviews = [];

    public function mount()
    {
        // Lấy danh sách 5 bình luận gần nhất
        $this->recentReviews = ProductReview::with('product', 'user')
            ->latest() // Sắp xếp theo thời gian mới nhất
            ->take(5) // Lấy 5 bình luận gần nhất
            ->get();
    }
    
    public function render()
    {
        return view('livewire.admin.dashboard.recent-reviews');
    }
}   
