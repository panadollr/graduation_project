<?php

namespace App\Livewire\Admin;

use App\Models\ShippingMethod;  
use Livewire\Component;
use Livewire\WithPagination;

class ShippingMethodManager extends Component
{
    use WithPagination;

    public $search = ''; 
    public $showEditModal = false;
    public $mode = 'create';
    public ShippingMethod $editing;
    public $shippingMethodData = ['name' => '', 'description' => '', 'price' => null, 'is_active' => null];
    public $sortField = 'price';
    public $sortDirection = 'desc'; 

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    // Quy tắc xác thực (không còn image)
    protected $rules = [
        'shippingMethodData.name' => 'required|string|max:255|unique:shipping_methods,name',
        'shippingMethodData.price' => 'required|numeric|min:0',
        'shippingMethodData.is_active' => 'required|boolean',
    ];

    // Thông báo lỗi
    public function messages()
    {
        return [
            'shippingMethodData.name.required' => 'Tên phương thức thanh toán là bắt buộc.',
            'shippingMethodData.name.unique' => 'Tên phương thức thanh toán đã tồn tại, vui lòng chọn tên khác.',
            'shippingMethodData.name.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự.',
            'shippingMethodData.price.required' => 'Giá là bắt buộc.',
            'shippingMethodData.price.numeric' => 'Giá phải là số.',
            'shippingMethodData.price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'shippingMethodData.is_active.required' => 'Tình trạng phải là bắt buộc.',
            'shippingMethodData.is_active.boolean' => 'Tình trạng không hợp lệ',
        ];
    }

    public function edit(ShippingMethod $shippingMethod)
    {
        $this->resetValidation();
        $this->editing = $shippingMethod;
        $this->mode = 'edit';
        $this->shippingMethodData = [
            'name' => $this->editing->name,
            'description' => $this->editing->description,
            'price' => (int) $this->editing->price,
            'is_active' => $this->editing->is_active,
        ];
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->resetValidation();
        $this->mode = 'create';
        $this->reset(['shippingMethodData']); 
        $this->showEditModal = true;
    }

    public function save()
    {
        if ($this->mode === 'edit') {
            $this->rules['shippingMethodData.name'] = 'required|string|max:255|unique:shipping_methods,name,' . $this->editing->id;
        }

        $this->validate(); // Xác thực đầu vào

        // Lưu hoặc cập nhật phương thức thanh toán
        if ($this->mode === 'edit') {
            $this->editing->update($this->shippingMethodData); // Cập nhật phương thức thanh toán
            $this->js('showToast("Phương thức thanh toán đã được cập nhật thành công.", "success")');
        } else {
            ShippingMethod::create($this->shippingMethodData); // Tạo phương thức thanh toán mới
            $this->js('showToast("Phương thức thanh toán đã được tạo thành công.", "success")');
        }

        $this->resetPage();
        $this->showEditModal = false; // Đóng modal
    }

    // Xóa phương thức thanh toán
    public function delete($id)
    {
        $shippingMethod = ShippingMethod::find($id);
        if ($shippingMethod) {
            $shippingMethod->delete();
            $this->js('showToast("Phương thức thanh toán đã được xóa thành công.", "success")');
        }
    }

    // Render component
    public function render()
    {
        $shippingMethods = ShippingMethod::search('name', $this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(5);

        return view('livewire.admin.shipping-method-manager', [
            'shippingMethods' => $shippingMethods
        ])
        ->extends('admin.app')
        ->layoutData(['title' => 'Hình thức vận chuyển']);
    }
}
