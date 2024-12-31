<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_id', 'title', 'slug', 'content', 'image', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Phương thức để lấy các blog liên quan
    public function relatedBlogs($limit = 4)
    {
        return Blog::where('id', '!=', $this->id) // Loại trừ blog hiện tại
            ->where('status', 1) // Chỉ lấy các blog đang hoạt động
            ->where(function ($query) {
                // Điều kiện lọc thêm, ví dụ cùng danh mục
                $query->where('category_id', $this->category_id)
                      ->orWhere('title', 'like', "%{$this->title}%");
            })
            ->latest()
            ->take($limit)
            ->get();
    }
}
