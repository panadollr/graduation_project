<?php

namespace App\Livewire\Client;

use App\Models\Product;
use App\Models\Sku;
use Livewire\Component;

class ProductAttributes extends Component
{
    public $product;
    public $productAttributes = []; // Đổi tên từ $attributes thành $productAttributes
    public $selectedOptions = [];
    public $selectedSku = null;

    public function mount(Product $product)
    {
        $this->product = $product;

        // Load attributes and options
        $this->productAttributes = $product->skus()
            ->with('attributeOptions.attribute')
            ->get()
            ->pluck('attributeOptions')
            ->flatten()
            ->groupBy('attribute.id')
            ->map(function ($options) {
                return $options->unique('id')->values();
            });
    }

    public function selectOption($attributeId, $optionId)
    {
        // Cập nhật lựa chọn
        $this->selectedOptions[$attributeId] = $optionId;

        // Tìm SKU tương ứng
        $this->selectedSku = Sku::whereHas('attributeOptions', function ($query) {
            $query->whereIn('attribute_option_id', $this->selectedOptions);
        }, '=', count($this->selectedOptions))->first();
    }

    public function render()
    {
        return view('livewire.client.product-attributes', [
            'productAttributes' => $this->productAttributes, // Truyền $productAttributes thay vì $attributes
            'selectedSku' => $this->selectedSku,
        ]);
    }
}
