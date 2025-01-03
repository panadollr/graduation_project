<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // Trả về mô tả trạng thái của đơn hàng
    public function getRoleString($role = null)
    {
        $role = $role ?? $this->role;
        $roleDescriptions = [
            'admin' => 'Quản trị viên',
            'employee' => 'Nhân viên',
            'user' => 'Khách hàng',
        ];

        return $roleDescriptions[$role] ?? 'Hệ thống';  // Trả về mặc định nếu không tìm thấy trạng thái
    }

    /**
     * Lấy lớp CSS của badge dựa trên vai trò người dùng.
     *
     * @return string
     */
    public function getRoleBadgeClass()
    {
        switch ($this->role) {
            case 'admin':
                return 'badge-success'; // màu xanh lá
            case 'employee':
                return 'badge-warning'; // màu vàng
            case 'user':
                return 'badge-primary'; // màu xanh nước biển
            default:
                return 'badge-secondary'; // mặc định (nếu có vai trò khác)
        }
    }
}
