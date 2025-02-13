<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Quản lý sản phẩm')]
class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filterCriteria;
    public $priceRange = [];

    public function filterByPrice($min, $max)
    {
        $this->priceRange = [$min, $max];
        $this->resetPage();
    }

    public function filterByCategory($category_id)
    {
        $this->category_id = $category_id;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->filterCriteria = null;
        $this->priceRange = [];
        $this->category_id = null;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            $this->js('showToast("Sản phẩm đã được xóa thành công.", "success")');
        }
    }

    // public function placeholder()
    // {
    //     return view('livewire.placeholders.placeholder');
    // }

    public function render()
    {
        $categories = Category::with('childrens')->select('id', 'name', 'parent_id')->get();

        $products = Product::with('category')
            ->when($this->search, fn($query) => $query->search('name', $this->search))
            ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id))
            ->when($this->filterCriteria, function ($query) {
                return $query->when($this->filterCriteria === 'low_sales', fn($q) => $q->where('sold_quantity', '<', 10))
                    ->when($this->filterCriteria === 'in_stock', fn($q) => $q->where('quantity', '>', 0))
                    ->when($this->filterCriteria === 'out_of_stock', fn($q) => $q->where('quantity', '=', 0))
                    ->when($this->filterCriteria === 'over_one_year', function ($q) {
                        return $q->whereRaw('COALESCE(stored_at, created_at) < ?', [now()->subYear()]);
                    })
                    ->when($this->filterCriteria === 'over_three_years', function ($q) {
                        return $q->whereRaw('COALESCE(stored_at, created_at) < ?', [now()->subYears(3)]);
                    });
            })
            ->when(!empty($this->priceRange), fn($query) => $query->whereBetween('sale_price', $this->priceRange))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(5);

        return view('livewire.admin.product.product-list', [
            'products' => $products,
            'categories' => $categories
        ])
            ->extends('admin.app')
            ->layoutData(['title' => 'Quản lý sản phẩm']);
    }
}
