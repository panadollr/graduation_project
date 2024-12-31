<?php

namespace App\Livewire\Admin\Discount;

use App\Models\Discount;
use Livewire\Component;

class DiscountEditor extends Component
{
    public $discountData = [
        'code' => '',
        'description' => '',
        'discount_value' => 0,
        'min_order_value' => 0,
        'usage_limit' => null,
        'start_date' => null,
        'end_date' => null,
        'status' => 1,
    ];
    public $discountId;

    protected function rules()
    {
        return [
            'discountData.code' => 'required|string|max:50|unique:discounts,code,' . $this->discountId,
            'discountData.discount_value' => 'required|numeric|min:1',
            'discountData.min_order_value' => 'nullable|numeric|min:1',
            'discountData.usage_limit' => 'nullable|integer|min:1',
            'discountData.start_date' => 'nullable|date',
            'discountData.end_date' => 'nullable|date|after_or_equal:discountData.start_date',
            'discountData.status' => 'required|boolean',
        ];
    }

    public function saveDiscount()
    { 
        // Lưu giá trị gốc của min_order_value trước khi thay đổi
        $originalMinOrderValue = $this->discountData['min_order_value'];

        // Loại bỏ dấu chấm và chuyển thành số nguyên
        $this->discountData['min_order_value'] = (int) str_replace('.', '', $this->discountData['min_order_value']); 

        $this->validate();

        if ($this->getErrorBag()->isNotEmpty()) {
            // Phục hồi min_order_value với định dạng ban đầu
            $this->discountData['min_order_value'] = $originalMinOrderValue;
        }

        Discount::updateOrCreate(
            ['id' => $this->discountId],
            $this->discountData
        );

        $this->discountData['min_order_value'] = $originalMinOrderValue;

        $this->js("alert($this->discountId ? 'Cập nhật mã thành công' : 'Thêm mã thành công')"); 
        return $this->redirect(route('admin.discount.index'), navigate: true);
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->discountId = $id;
            $discount = Discount::findOrFail($id);
            $this->discountData = $discount->toArray();
        }
    }

    public function render()
    {
        return view('livewire.admin.discount.discount-editor', ['title' => $this->discountId ? 'Chỉnh sửa mã giảm giá' : 'Thêm mã giảm giá'])
        ->extends('admin.app')
        ->layoutData(['title' => $this->discountId ? 'Chỉnh sửa mã giảm giá' : 'Thêm mã giảm giá']);
    }
}
