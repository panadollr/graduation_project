<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'description',
        'discount_value',
        'min_order_value',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'status'
    ];

     /**
     * Kiểm tra xem mã giảm giá có còn hiệu lực không và có áp dụng được cho người dùng không.
     */
    public function isValid()
    {
        // Kiểm tra điều kiện chung (thời gian, trạng thái, số lần sử dụng)
        if (!($this->status == 1
            && ($this->start_date === null || now()->greaterThanOrEqualTo($this->start_date))
            && ($this->end_date === null || now()->lessThanOrEqualTo($this->end_date))
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit))) {
            return false;
        }

        return true;
    }

    /**
     * Mối quan hệ với bảng users thông qua bảng trung gian discount_user.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'discount_user', 'discount_id', 'user_id')
            ->withTimestamps();
    }   
}
