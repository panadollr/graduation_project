<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'action',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Phương thức để ghi log chung
    public static function logAction($userId, $action)
    {
        self::create([
            'user_id' => $userId,
            'action' => $action,
        ]);
    }
}
