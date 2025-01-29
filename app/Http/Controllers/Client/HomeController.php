<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    protected $resourceDir = 'client.home';
    public function index(){
        $sliders = Slider::all();
        $categories = Category::with('products')->get();

        $popularCategories = Category::whereNull('parent_id')->take(6)->get();

        // Lấy sản phẩm đang giảm giá
        $saleProducts = Product::where('discount_percentage', '>', 0)
        ->with(['category'])
        ->withCount(['reviews' => function ($query) {
            $query->whereNull('parent_id'); // Chỉ đếm các reviews có parent_id là null
        }])
        ->orderByDesc('discount_percentage')
        ->take(10)
        ->get();
        
        $categoriesOfSaleProducts = $saleProducts->pluck('category')->unique();

        $blogs = Blog::select('title', 'slug', 'image', 'created_at', 'category_id')
            ->take(12)->latest()->get();

        return view($this->resourceDir . '.index', compact(
            'sliders',
            'categories',
            'popularCategories',
            'categoriesOfSaleProducts',
            'blogs',
            'saleProducts',
        ));
    }
}
