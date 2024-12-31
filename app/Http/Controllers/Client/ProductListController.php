<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ProductListController extends Controller
{
    protected $resourceDir = 'client.list';
    public function index($category_slug){
        return view($this->resourceDir . '.index', compact('category_slug'));
    }

    public function search()
    {
        $search = request()->input('s');
        
        return view($this->resourceDir . '.index', compact('search'));
    }
}
