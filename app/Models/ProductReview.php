<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
    protected $fillable = [
        "user_id",
        "product_id",
        "rating",
        "comment",
        "parent_id"
      ];

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function product(){
      return $this->belongsTo(Product::class);
    }
    
    public function replies()
  {
      return $this->hasMany(ProductReview::class, 'parent_id');
  }
}
