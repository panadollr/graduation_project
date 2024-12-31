<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductDetailController extends Controller
{
    protected $resourceDir = 'client.product-detail';
    public function index($product_slug){
        $product = Product::where('slug', $product_slug)->firstOrFail();
        $productId = $product->id;

        $relatedProducts = $product->category->products()->where('id', '!=', $product->id)->get();

        $alsoLikeProducts = Product::take(10)->get();

        return view($this->resourceDir . '.index', compact('product', 'product_slug', 'productId', 'alsoLikeProducts',  'relatedProducts'));
    }
}
