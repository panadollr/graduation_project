<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'city',    // Cột city
        'district',    // Cột district
        'ward',  // Cột ward
        'address',
        'is_default',
    ];
}
