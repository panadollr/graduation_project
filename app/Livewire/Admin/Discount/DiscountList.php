<?php

namespace App\Livewire\Admin\Discount;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;

class DiscountList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc'; 
    public $perPage = 10;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        session()->flash('success', 'Mã giảm giá đã được xóa thành công!');
    }

    public function render()
    {
        $discounts = Discount::where('code', 'like', "%{$this->search}%")
            ->orWhere('description', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection) // Sắp xếp
            ->paginate($this->perPage);

        return view('livewire.admin.discount.discount-list', [
            'discounts' => $discounts,
        ])
        ->extends('admin.app')
        ->layoutData(['title' => 'Quản lý mã giảm giá']);
    }
}
