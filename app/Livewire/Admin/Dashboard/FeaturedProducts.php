<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Product;
use Livewire\Component;

class FeaturedProducts extends Component
{
    public $filterType = 'top_rated'; // Mặc định là "Đánh giá cao"

    public function render()
    {
        // Khởi tạo query chung
        $query = Product::query()->withAvg('reviews', 'rating')->withCount('carts');

        switch ($this->filterType) {
            case 'top_rated':
                $query->having('reviews_avg_rating', '>=', 4) // Lọc sản phẩm có rating trung bình >= 4
                    ->orderBy('reviews_avg_rating', 'desc'); // Sắp xếp theo rating giảm dần
                break;

            case 'most_added_to_cart':
                $query->orderBy('carts_count', 'desc'); // Sắp xếp theo số lần thêm vào giỏ
                break;

            case 'best_selling':
                $query->orderBy('sold_quantity', 'desc'); // Sắp xếp theo số lượng bán
                break;

            default:
                return view('livewire.admin.dashboard.featured-products', [
                    'products' => collect(), // Trả về collection rỗng
                ]);
        }

        // Giới hạn và lấy sản phẩm
        $products = $query->take(5)->get();

        return view('livewire.admin.dashboard.featured-products', [
            'products' => $products,
        ]);
    }
}
