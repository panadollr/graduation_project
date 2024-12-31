<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        "name",
        "slug",
        'image',
        "parent_id",
        "type"
      ];

    // Mối quan hệ với danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function ancestors()
  {
      $ancestors = collect();
      $parent = $this->parent;

      while ($parent) {
          $ancestors->prepend($parent);
          $parent = $parent->parent;
      }

      return $ancestors;
  }
  
    // Mối quan hệ với các danh mục con
    public function childrens()
    {
          return $this->hasMany(Category::class, 'parent_id')->with('childrens');
    }

    public function getAllChildrenIds()
    {
        $categoryIds = collect([$this->id]);

        foreach ($this->childrens as $child) {
            $categoryIds = $categoryIds->merge($child->getAllChildrenIds());
        }

        return $categoryIds;
    }

    // Hàm để lấy tất cả sản phẩm từ danh mục hiện tại và danh mục con
    public function allProducts()
    {
        return Product::whereIn('category_id', $this->getAllChildrenIds());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(ProductReview::class, Product::class);
    }
}
