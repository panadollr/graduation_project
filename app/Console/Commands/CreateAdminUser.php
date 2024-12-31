<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    // Tên của command, sẽ sử dụng trong terminal
    protected $signature = 'lk2_cms:user';

    // Mô tả về command
    protected $description = 'Tạo tài khoản admin mới';

    /**
     * Thực thi lệnh.
     *
     * @return int
     */
    public function handle()
    {
        // Hỏi người dùng nhập thông tin tài khoản
        $name = $this->ask('Tên tài khoản admin');
        $email = $this->ask('Email tài khoản admin');
        $password = $this->secret('Mật khẩu tài khoản admin');

        // Kiểm tra xem email đã tồn tại chưa
        if (User::where('email', $email)->exists()) {
            $this->error('Email đã tồn tại. Vui lòng chọn email khác.');
            return 1;
        }

        // Tạo tài khoản admin mới
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);

        $this->info("Tài khoản admin {$user->name} đã được tạo thành công!");
        return 0;
    }
}
