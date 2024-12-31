<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'order_status_history';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    protected $fillable = [
        'order_id',
        'status',
        'changed_by',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id');
    }

    public function getStatusString($status = null)
    {
        $status = $status ?? $this->status;
        $statusDescriptions = [
            'pending' => 'Đang chờ xác nhận',
            'shipped' => 'Đang giao hàng',
            'completed' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
        ];

        return $statusDescriptions[$status] ?? 'Chưa xác định';  // Trả về mặc định nếu không tìm thấy trạng thái
    }
}
