<?php

namespace App\Livewire\Client;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductList extends Component
{
    public $title;
    public $selectedBrands = [];
    public $minPrice;
    public $maxPrice;
    public $defaultMinPrice;
    public $defaultMaxPrice;
    public $category_slug;
    public $category;
    public $search;

    public $selectedSort= 'sale';
    public $sortOptions = [
        'discount_rate' => 'Giảm giá mạnh',
        'rating' => 'Đánh giá cao',
        'bestseller' => 'Bán chạy',
        'high_price' => 'Giá: Cao đến thấp',
        'low_price' => 'Giá: Thấp đến cao',
    ];
    

    public $selectedPrice = null; 
    public $priceRanges = [
        'under_2m' => 'Dưới 2 triệu',
        '2m_4m' => 'Từ 2 triệu đến 4 triệu',
        '4m_7m' => 'Từ 4 triệu đến 7 triệu',
        '4m_7m' => 'Từ 4 triệu đến 7 triệu',
        '7m_13m' => 'Từ 7 triệu đến 13 triệu',
        '13m_20m' => 'Từ 13 triệu đến 20 triệu',
        'above_20m' => 'Trên 20 triệu'
    ];

    public function mount($category_slug)
    {
        $this->category_slug = $category_slug;
        $this->category = Category::with('childrens')->where('slug', $this->category_slug)->first();
        $this->search = request()->query('s', '');

        $this->title = $this->category
            ? $this->category->name . ' - Danh sách sản phẩm'
            : ($this->search ? "Tìm kiếm: '{$this->search}' - Danh sách sản phẩm" : 'Sản phẩm - Danh sách');
        
        $childrenIds = $this->category ? $this->category->getAllChildrenIds() : [];
        $this->defaultMinPrice = Product::whereIn('category_id', $childrenIds)->min('base_price') ?? 100000;
        $this->defaultMaxPrice = Product::whereIn('category_id', $childrenIds)->max('base_price') ?? 20000000;

        $this->minPrice = $this->defaultMinPrice;
        $this->maxPrice = $this->defaultMaxPrice;
    }

    public function resetPriceRange()
    {
        $this->minPrice = $this->defaultMinPrice;
        $this->maxPrice = $this->defaultMaxPrice;
    }

    public function selectBrand($brand_id)
    {
        $this->selectedBrands = in_array($brand_id, $this->selectedBrands)
            ? array_diff($this->selectedBrands, [$brand_id])
            : array_merge($this->selectedBrands, [$brand_id]);
    }

    public function updatePriceRange($min, $max)
    {
        $this->minPrice = (int) str_replace(',', '', $min);
        $this->maxPrice = (int) str_replace(',', '', $max);
    }

    public function clearFilters()
    {
        $this->selectedBrands = [];
        $this->resetPriceRange();
        $this->search = '';
    }

    public function render()
    {
        $query = $this->category->allProducts();

        if ($this->selectedBrands) {
            $brandIds = Category::whereIn('id', $this->selectedBrands)
                ->with('childrens')
                ->get()
                ->flatMap(fn($brand) => $brand->getAllChildrenIds())
                ->toArray();
            $query->whereIn('category_id', $brandIds);
        }

        // Thêm điều kiện tìm kiếm
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $query->when($this->selectedPrice, function ($q) {
            switch ($this->selectedPrice) {
                case 'under_2m':
                    $q->where('sale_price', '<', 2000000);
                    break;
                case '2m_4m':
                    $q->whereBetween('sale_price', [2000000, 4000000]);
                    break;
                case '4m_7m':
                    $q->whereBetween('sale_price', [4000000, 7000000]);
                    break;
                case '7m_13m':
                    $q->whereBetween('sale_price', [7000000, 13000000]);
                    break;
                case '13m_20m':
                    $q->whereBetween('sale_price', [13000000, 20000000]);
                    break;
                case 'above_20m':
                    $q->where('sale_price', '>', 20000000);
                    break;
            }
        });
        

        $query->when($this->selectedSort, function ($q) {
            switch ($this->selectedSort) {
                case 'sale':
                    $q->orderByDesc('discount_percentage');
                    break;
                case 'rating':
                    $q->withAvg('reviews', 'rating') // Tính giá trị trung bình cột rating
                      ->orderByDesc('reviews_avg_rating'); // Sắp xếp giảm dần
                    break;
                case 'high_price':
                    $q->orderByDesc('sale_price');
                    break;
                case 'low_price':
                    $q->orderBy('sale_price');
                    break;
                case 'bestseller':
                    $q->orderByDesc('sold_quantity');
                    break;
            }
        });
        
        $products = $query->whereBetween('sale_price', [$this->minPrice, $this->maxPrice])
                          ->paginate(10);

        return view('client.list.livewire.product-list', [
            'products' => $products,
            'categories' => Category::all(),
            'brands' => $this->category?->childrens->where('type', 'manufacturer') ?? null,
        ]);
    }
}

