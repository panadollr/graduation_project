<?php

namespace App\Livewire\Client\Blog;

use Livewire\Component;
use App\Models\Blog; // Import the Blog model
use Livewire\WithPagination; // Import pagination trait

class BlogList extends Component
{
    use WithPagination; // Enable pagination in the component
    public $search = '';

    public function render()
    {
        $blogs = Blog::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->paginate(10); // Fetch blogs with pagination (10 per page)

        $relatedBlogIds = $blogs->pluck('id');
        $relatedBlogs = Blog::whereNotIn('id', $relatedBlogIds)
                ->inRandomOrder()
                ->limit(5)
                ->get();

        return view('livewire.client.blog.blog-list', compact('blogs', 'relatedBlogs'))
        ->extends('client.app');
    }
}
