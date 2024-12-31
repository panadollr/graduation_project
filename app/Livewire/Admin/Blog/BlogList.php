<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogList extends Component
{
    use WithPagination;

    public $search = '';
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

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        $this->js('showToast("Xóa bài viết thành công.", "success")');
    }

    public function render()
    {
        $blogs = Blog::query()
        ->where('title', 'like', "%{$this->search}%")
        ->orWhere('content', 'like', "%{$this->search}%")
        ->orderBy($this->sortField ?? 'created_at', $this->sortDirection ?? 'desc') // Sắp xếp
        ->paginate(10);


        return view('livewire.admin.blog.blog-list', compact('blogs'))
        ->extends('admin.app')
        ->layoutData(['title' => 'Quản lý bài viết']);
    }
}
