<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CategoryManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = ''; 
    public $showEditModal = false;
    public $mode = 'create';
    public Category $editing;
    public $categoryData = ['name' => '', 'slug' => ''];
    public $types = [
        'manufacturer' => 'Hãng sản xuất',
        'operating_system' => 'Hệ điều hành',
    ];
    public $parentCategories;

    public $sortField = 'created_at';
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

    protected $rules = [
        'categoryData.name' => 'required|string|max:255|unique:categories,name',
        'categoryData.slug' => 'required|string|max:255|unique:categories,slug',
        'categoryData.image' => 'required',
    ];

    public function messages()
    {
        return [
            'categoryData.name.required' => 'Tên danh mục là bắt buộc.',
            'categoryData.name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
            'categoryData.name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'categoryData.slug.required' => 'Slug là bắt buộc.',
            'categoryData.slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'categoryData.slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'categoryData.image.required' => 'Ảnh là bắt buộc.',
            'categoryData.image.image' => 'Ảnh phải là ảnh.',
        ];
    }

    public function edit(Category $category)
    {
        $this->resetValidation();
        $this->editing = $category;
        $this->mode = 'edit';
        $this->categoryData = [
            'name' => $this->editing->name,
            'slug' => $this->editing->slug,
            'image' => $this->editing->image,
            'type' => $this->editing->type,
            'parent_id' => $this->editing->parent_id,
        ];
        $this->parentCategories = Category::select('id', 'name')->where('id', '!=', $category->id)->get();
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->resetValidation();
        $this->mode = 'create';
        $this->categoryData = ['name' => '', 'slug' => '', 'image' => '',];
        $this->parentCategories = Category::select('id', 'name')->get();
        $this->showEditModal = true;
    }

    public function saveCategory()
    {
        if ($this->mode === 'edit') {
            $this->rules['categoryData.name'] = 'required|string|max:255|unique:categories,name,' . $this->editing->id;
            $this->rules['categoryData.slug'] = 'required|string|max:255|unique:categories,slug,' . $this->editing->id;
            unset($this->rules['categoryData.image']);
        }

        $this->validate(); // Validate the inputs

        if (isset($this->categoryData['image'])) {
            if ($this->categoryData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $slug = $this->categoryData['slug'];
                $extension = $this->categoryData['image']->getClientOriginalExtension();
                $imagePath = $this->categoryData['image']->storeAs('category-images', $slug . '.' . $extension, 'public');
                $this->categoryData['image'] = $imagePath;
            }
        } else {
            if ($this->mode === 'edit') {
                unset($this->categoryData['image']);
            }
        }

        if ($this->mode === 'edit') {
            $this->editing->update($this->categoryData); // Update the category
            $this->js('showToast("Danh mục đã được cập nhật thành công.", "success")');
        } else {
            Category::create($this->categoryData); // Create a new category
            $this->js('showToast("Danh mục đã được tạo thành công.", "success")');
        }

        $this->resetPage();
        $this->showEditModal = false; // Close the modal
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            $this->js('showToast("Danh mục đã được xóa thành công.", "success")');
        }
    }

    public function render()
    {
        $categories = Category::with('childrens')->search('name', $this->search)
        ->orderBy($this->sortField, $this->sortDirection)->paginate(5);

        return view('livewire.admin.category-manager', [
            'categories' => $categories
        ])
        ->extends('admin.app')
        ->section('content')
        ->layoutData(['title' => 'Quản lý đơn hàng']);
    }
}
