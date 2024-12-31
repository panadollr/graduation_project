<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class BlogEditor extends Component
{
    use WithFileUploads;

    public $blogId = null;
    public $blogData = [
        'title' => '',
        'slug' => '',
        'content' => '',
        'image' => null,
        'status' => 1,
    ];

    protected function rules()
    {
        return [
            'blogData.title' => 'required|string|max:255',
            'blogData.slug' => 'required|string|max:255|unique:blogs,slug,' . $this->blogId,
            'blogData.content' => 'required',
            'blogData.image' => 'required|image|max:1024',
            'blogData.status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'blogData.title.required' => 'Tiêu đề là bắt buộc.',
            'blogData.slug.required' => 'Slug bài viết là bắt buộc',
            'blogData.content.required' => 'Nội dung bài viết là bắt buộc',
            'blogData.image.required' => 'Hình ảnh bài viết là bắt buộc',
            'blogData.image.image' => "Hình ảnh bài viết phải có định dạng là ảnh"
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $blog = Blog::findOrFail($id);
            $this->blogId = $blog->id;
            $this->blogData = $blog->toArray();
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->blogData['image'] && $this->blogData['image'] instanceof TemporaryUploadedFile) {
            $imagePath = $this->blogData['image']->store('blog', 'public');
            $this->blogData['image'] = $imagePath;
        }

        Blog::updateOrCreate(
            ['id' => $this->blogId],
            [
                'title' => $this->blogData['title'],
                'slug' => Str::slug($this->blogData['title']),
                'content' => $this->blogData['content'],
                'image' => $this->blogData['image'] ?? null,
                'status' => $this->blogData['status'],
            ]
        );

        return redirect()->route('admin.blog.index');
    }

    public function render()
    {
        return view('livewire.admin.blog.blog-editor', [
            'title' => $this->blogId ? 'Chỉnh sửa bài viết' : 'Thêm bài viết mới'
        ])
        ->extends('admin.app')
        ->layoutData(['title' => $this->blogId ? 'Chỉnh sửa bài viết' : 'Thêm bài viết mới']);
    }
}
