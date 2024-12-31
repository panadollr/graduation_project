<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Category;
use Livewire\Component;

class ProductCategoryChart extends Component
{
    public $chartData = [];

    public function mount()
    {
        // Lấy danh mục cha (parent_id = null)
        $categories = Category::whereNull('parent_id')
        ->with(['childrens.products.orderItems', 'products.orderItems']) // Load quan hệ danh mục con và sản phẩm
        ->get()
        ->map(function ($category) {
            $totalSold = $category->products->sum(fn($product) => $product->orderItems->sum('quantity')) +
            $category->childrens->sum(function ($child) {
                return $child->products->sum(fn($product) => $product->orderItems->sum('quantity'));
            });
            return [
                'name' => $category->name,
                'products_count' => $totalSold,
            ];
        })
        ->sortByDesc('products_count') 
        ->take(4); 

        $this->chartData = [
            'labels' => $categories->pluck('name')->toArray(),
            'data' => $categories->pluck('products_count')->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard.product-category-chart');
    }
}
