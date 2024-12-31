<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'image',
        'link_url',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($slider) {
            if ($slider->image) {
                // Xóa file ảnh từ storage
                $imagePath = str_replace('/storage/', 'public/', $slider->image);
                Storage::delete($imagePath);
            }
        });
    }

    // Các giá trị trạng thái
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * Kiểm tra slider có đang hoạt động không.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
