<?php

namespace App\Livewire\Admin\Slider;

use Livewire\Component;
use App\Models\Slider;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SliderEditor extends Component
{
    use WithFileUploads;

    public $sliderData = [
        'title' => '', 
        'description' => '',
        'image' => null, // Trường ảnh đại diện
        'link_url' => '', 
        'status' => 1, 
    ];

    protected function rules()
    {
        $rules = [
            'sliderData.title' => 'required|string|max:255',
            'sliderData.link_url' => 'required|url',
            'sliderData.status' => 'required|in:0,1',
        ];

        if (!isset($this->sliderId)) {
            $rules['sliderData.image'] = 'required|image';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'sliderData.title.required' => 'Tiêu đề slider là bắt buộc.',
            'sliderData.title.string' => 'Tiêu đề slider phải là chuỗi ký tự.',
            'sliderData.title.max' => 'Tiêu đề slider không được dài quá 255 ký tự.',
            'sliderData.image.required' => 'Ảnh đại diện là bắt buộc.',
            'sliderData.image.image' => 'Tệp tải lên phải là hình ảnh.',
            'sliderData.link_url.required' => 'Đường link là bắt buộc.',
            'sliderData.link_url.url' => 'Đường link phải hợp lệ.',
            'sliderData.status.required' => 'Trạng thái là bắt buộc.',
            'sliderData.status.in' => 'Trạng thái phải là 0 hoặc 1.',
        ];
    }

    public $sliderId = null; // Sử dụng để xác định xem đang tạo mới hay chỉnh sửa

    public function mount($id = null)
    {
        if ($id) {
            $slider = Slider::findOrFail($id);
            $this->sliderId = $slider->id;
            $this->sliderData = $slider->toArray();
        }
    }

    public function saveSlider()
    {
        $this->validate();

        // Xử lý upload ảnh đại diện
        $image = $this->sliderData['image'];
        if ($image instanceof TemporaryUploadedFile) {
            $imagePath = $image->storeAs('sliders', uniqid() . '.webp', 'public');
            $this->sliderData['image'] = Storage::url($imagePath);
        } elseif ($this->sliderId && is_string($image)) {
            // Nếu chỉnh sửa và ảnh đại diện là đường dẫn cũ thì giữ nguyên
            $this->sliderData['image'] = $image;
        } else {
            $this->sliderData['image'] = null;
        }

        Slider::updateOrCreate(
            ['id' => $this->sliderId],
            $this->sliderData
        );

        session()->flash('success', $this->sliderId ? 'Cập nhật slider thành công' : 'Thêm slider thành công');
        return redirect()->route('admin.slider.index');
    }

    public function render()
    {
        return view('livewire.admin.slider.editor', [
            'title' => $this->sliderId ? 'Chỉnh sửa slider' : 'Thêm slider mới'
        ])->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => $this->sliderId ? 'Chỉnh sửa slider' : 'Thêm slider mới']);
    }
}
