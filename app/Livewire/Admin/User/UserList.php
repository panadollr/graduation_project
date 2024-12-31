<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class UserList extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = ''; 
    public $showEditModal = false;
    public $mode = 'create';
    public User $editing;
    public $UserData = ['name' => '', 'slug' => ''];
    public $parentCategories;

    public $sortField = 'role';
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
        'UserData.name' => 'required|string|max:255|unique:categories,name',
        'UserData.slug' => 'required|string|max:255|unique:categories,slug',
        'UserData.image' => 'required',
    ];

    public function messages()
    {
        return [
            'UserData.name.required' => 'Tên danh mục là bắt buộc.',
            'UserData.name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
            'UserData.name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'UserData.slug.required' => 'Slug là bắt buộc.',
            'UserData.slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'UserData.slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'UserData.image.required' => 'Ảnh là bắt buộc.',
            'UserData.image.image' => 'Ảnh phải là ảnh.',
        ];
    }

    public function edit(User $User)
    {
        $this->resetValidation();
        $this->editing = $User;
        $this->mode = 'edit';
        $this->UserData = [
            'name' => $this->editing->name,
            'slug' => $this->editing->slug,
            'image' => $this->editing->image,
            'parent_id' => $this->editing->parent_id
        ];
        $this->parentCategories = User::select('id', 'name')->where('id', '!=', $User->id)->get();
        $this->showEditModal = true;
    }

    public function create()
    {
        $this->resetValidation();
        $this->mode = 'create';
        $this->UserData = ['name' => '', 'slug' => '', 'image' => '',];
        $this->parentCategories = User::select('id', 'name')->get();
        $this->showEditModal = true;
    }

    public function saveUser()
    {
        if ($this->mode === 'edit') {
            $this->rules['UserData.name'] = 'required|string|max:255|unique:categories,name,' . $this->editing->id;
            $this->rules['UserData.slug'] = 'required|string|max:255|unique:categories,slug,' . $this->editing->id;
            unset($this->rules['UserData.image']);
        }

        $this->validate(); // Validate the inputs

        if (isset($this->UserData['image'])) {
            if ($this->UserData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $slug = $this->UserData['slug'];
                $extension = $this->UserData['image']->getClientOriginalExtension();
                $imagePath = $this->UserData['image']->storeAs('User-images', $slug . '.' . $extension, 'public');
                $this->UserData['image'] = $imagePath;
            }
        } else {
            if ($this->mode === 'edit') {
                unset($this->UserData['image']);
            }
        }

        if ($this->mode === 'edit') {
            $this->editing->update($this->UserData); // Update the User
            $this->js('showToast("Danh mục đã được cập nhật thành công.", "success")');
        } else {
            User::create($this->UserData); // Create a new User
            $this->js('showToast("Danh mục đã được tạo thành công.", "success")');
        }

        $this->resetPage();
        $this->showEditModal = false; // Close the modal
    }

    // Xóa danh mục
    public function deleteUser($id)
    {
        $User = User::find($id);
        if ($User) {
            $User->delete();
            $this->js('showToast("Xóa người dùng thành công.", "success")');
        }
    }

    public function render()
    {
        $users = User::search('name', $this->search)
        ->when($this->sortField === 'role', function ($query) {
            $query->orderByRaw("FIELD(role, 'employee', 'customer', 'admin') {$this->sortDirection}");
        })
        ->when($this->sortField !== 'role', function ($query) {
            // Apply normal sorting for other fields
            $query->orderBy($this->sortField, $this->sortDirection);
        })
        ->paginate(5);

        return view('livewire.admin.user.user-list', [
            'users' => $users
        ])
        ->extends('admin.app')
        ->layoutData(['title' => 'Danh sách người dùng']);
    }
}
