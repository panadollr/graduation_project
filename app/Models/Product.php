<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
  use HasFactory;
  protected $table = 'products';
  protected $primaryKey = 'id';
  protected $fillable = [
    "name",
    "slug",
    "base_price",
    "sale_price",
    "short_description",
    "description",
    "category_id",
    "featured_image",  // Thêm trường ảnh đại diện
    "additional_images", // Đổi tên trường images thành additional_images
    "quantity",
    "reserved_quantity",
    "sold_quantity",
    "discount_percentage",
    "status",
    "store_at"
  ];

  protected static function boot()
  {
    parent::boot();

    static::created(function () {
      Cache::flush();
    });

    static::updated(function () {
      Cache::flush();
    });

    static::deleted(function () {
      Cache::flush();
    });
  }

  //RELATIONS
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function brand()
  {
    return $this->category()->where('type', 'manufacturer');
  }

  // Quan hệ với bảng product_reviews
  public function reviews()
  {
    return $this->hasMany(ProductReview::class);
  }

  public function carts()
  {
    return $this->hasMany(Cart::class);
  }

  //FUNCTIONS
  public function url()
  {
    return route('product', ['product_slug' => $this->attributes['slug']]);
  }

  public function getImages()
  {
    return json_decode(stripslashes($this->additional_images), true);
  }


  // Nếu cần, bạn có thể tạo một accessor để truy xuất ảnh đại diện
  public function getFeaturedImageUrlAttribute()
  {
    return $this->featured_image ? url($this->featured_image) : asset('/client/assets/images/404.webp');
  }

  public function getAdditionalImagesUrlsAttribute()
  {
    return array_map(function ($image) {
      return url($image);
    }, json_decode($this->additional_images, true) ?? []);
  }

  public function getAvailableStock(): int
  {
    return $this->quantity - $this->reserved_quantity - $this->sold_quantity;
  }

  public function isInStock(int $quantity = 1): bool
  {
    $availableStock = $this->quantity - $this->reserved_quantity;
    return $availableStock >= $quantity;
  }

  public function reserveStock($amount)
  {
    // Kiểm tra xem số lượng trong kho có đủ để đặt trước không
    if ($this->quantity >= $amount) {
      // Giảm số lượng thực tế trong kho
      $this->quantity -= $amount;
      // Tăng số lượng đã được đặt trước
      $this->reserved_quantity += $amount;
      $this->save();
      // Trả về true nếu đặt trước thành công
      return true;
    }
    // Trả về false nếu không đủ hàng để đặt trước
    return false;
  }

  public function releaseStock($amount)
  {
    // Kiểm tra xem số lượng đặt trước có đủ để hủy bỏ không
    if ($this->reserved_quantity >= $amount) {
      // Tăng lại số lượng thực tế trong kho
      $this->quantity += $amount;
      // Giảm số lượng đã đặt trước
      $this->reserved_quantity -= $amount;
      $this->save();
      return true;
    }
    return false;
  }

  public function confirmStock($amount)
  {
    // Kiểm tra xem số lượng đặt trước có đủ để xác nhận không
    if ($this->reserved_quantity >= $amount) {
      // Giảm số lượng đã đặt trước
      $this->reserved_quantity -= $amount;
      // Tăng số lượng đã bán
      $this->sold_quantity += $amount;
      $this->save();
      // Trả về true nếu xác nhận bán thành công
      return true;
    }
    // Trả về false nếu không đủ số lượng đặt trước để xác nhận
    return false;
  }

  // Phương thức để lọc sản phẩm tồn kho lâu năm
  public static function getOldStock($months = 12)
  {
    // Lọc sản phẩm tồn kho lâu hơn một khoảng thời gian (mặc định là 12 tháng)
    return self::where('quantity', '>', 0)
      ->whereDate('store_at', '<', Carbon::now()->subMonths($months))
      ->get();
  }

  public static function applyDiscountForOldStock($months = 12, $discountPercentage = 20)
  {
    $oldStockProducts = self::getOldStock($months);

    foreach ($oldStockProducts as $product) {
      $product->sale_price = $product->base_price * (1 - $discountPercentage / 100);
      $product->save();
    }
  }
}
