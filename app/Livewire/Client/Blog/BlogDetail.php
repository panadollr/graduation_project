<?php

namespace App\Livewire\Client\Blog;

use App\Models\Blog;
use Livewire\Component;

class BlogDetail extends Component
{
    public Blog $blog;
    
    public function mount($slug){
        $this->blog = Blog::where('slug', $slug)->firstOr(function () {
            abort(404);
        });
    }

    public function render()
    {
        $previousBlog = Blog::where('id', '<', $this->blog->id)
                        ->orderBy('id', 'desc')
                        ->first();

        $nextBlog = Blog::where('id', '>', $this->blog->id)
                        ->orderBy('id', 'asc')
                        ->first();
        return view('livewire.client.blog.blog-detail', compact('previousBlog', 'nextBlog'))->extends('client.app');
    }
}
