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

    /**
     * Relationship with Setting for City.
     */
    public function getCityNameAttribute()
    {
        $citySetting = Setting::where('key', 'cities')
            ->get()
            ->map(function ($item) {
                $data = json_decode($item->value, true);
                return array_merge(['name' => $item->name], $data);
            })
            ->firstWhere('id', $this->city);

        return $citySetting['name'] ?? 'N/A';
    }

    /**
     * Relationship with Setting for District.
     */
    public function getDistrictNameAttribute()
    {
        $districtSetting = Setting::where('key', 'districts')
            ->get()
            ->map(function ($item) {
                $data = json_decode($item->value, true);
                return array_merge(['name' => $item->name], $data);
            })
            ->firstWhere('id', $this->district);

        return $districtSetting['name'] ?? 'N/A';
    }

    /**
     * Relationship with Setting for Ward.
     */
    public function getWardNameAttribute()
    {
        $wardSetting = Setting::where('key', 'wards')
            ->get()
            ->map(function ($item) {
                $data = json_decode($item->value, true);
                return array_merge(['name' => $item->name], $data);
            })
            ->firstWhere('id', $this->ward);

        return $wardSetting['name'] ?? 'N/A';
    }
}
