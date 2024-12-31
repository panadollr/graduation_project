<?php

namespace App\Livewire\Client;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProductSearch extends Component
{
    #[Url()] 
    public $search = '';
    public $products = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->products = Product::search('name', $this->search)
            ->orWhereHas('category', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->take(10)
            ->get(['name', 'slug', 'featured_image', 'sale_price']);

        } else {
            $this->products = [];
        }
    }

    public function selectProduct($productSlug)
    {
        return redirect()->route('product', ['product_slug' => $productSlug]);
    }

    public function render()
    {
        return view('livewire.client.product-search',[
            'search ' => $this->search
        ]);
    }
}
