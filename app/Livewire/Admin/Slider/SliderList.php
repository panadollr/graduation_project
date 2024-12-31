<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class SliderList extends Component
{
    use WithPagination;

    public $search = ''; 
    public $sortField = 'created_at';
    public $sortDirection = 'desc'; 
    public $lazyPlaceholder = 'livewire.placeholders.custom-loading';

    public function render()
    {
         // Lấy danh sách slider với bộ lọc và phân trang
         $sliders = Slider::when($this->search, function ($query) {
            return $query->where('title', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(5);

        return view('livewire.admin.slider.list', [
            'sliders' => $sliders
        ])
        ->extends('admin.app')
        ->layoutData(['title' => 'Quản lý Slider']);
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


    // Xóa slider
    public function delete($id)
    {
        $slider = Slider::find($id);
        if ($slider) {
            $slider->delete();
            $this->js('showToast("Slider đã được xóa thành công.", "success")');
        }
    }

    // Kích hoạt/Ngừng kích hoạt slider
    public function toggleStatus($id)
    {
        $slider = Slider::find($id);
        if ($slider) {
            $slider->status = $slider->isActive() ? Slider::STATUS_INACTIVE : Slider::STATUS_ACTIVE;
            $slider->save();
            $this->js('showToast("Trạng thái slider đã được cập nhật.", "success")');
        }
    }
}
