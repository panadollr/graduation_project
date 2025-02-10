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
    public function index()
    {
        try {
            $sliders = Slider::select(['image', 'link_url'])->take(10)->get();

            $popularCategories = Category::take(6)->get();

            // Lấy sản phẩm đang giảm giá
            $saleProducts = Product::where('discount_percentage', '>', 0)
                ->with(['category:id,name', 'reviews'])
                ->withCount(['reviews as reviews_count' => function ($query) {
                    $query->whereNull('parent_id');
                }])
                ->orderByDesc('discount_percentage')
                ->take(10)
                ->get();

            $categoriesOfSaleProducts = $saleProducts->pluck('category')->unique();

            $blogs = Blog::select('title', 'slug', 'image', 'created_at', 'category_id')
                ->with(['category:id,name'])
                ->take(12)
                ->latest()
                ->get();

            // return view($this->resourceDir . '.index', compact(
            //     'sliders',
            //     'popularCategories',
            //     'saleProducts',
            //     'categoriesOfSaleProducts',
            //     'blogs',
            // ));

            return view('client.home.index');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'ha' => 'ha']);
        }
    }
}
