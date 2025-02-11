<?php

namespace App\Livewire\Client;

use App\Models\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
    ];

    // public function login()
    // {
    //     $this->validate();

    //     if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
    //         Log::logAction(auth()->id(), 'Đã đăng nhập vào hệ thống !');
    //         return $this->redirect(request()->header('Referer', '/'), navigate: true);
    //     }

    //     // Nếu thất bại, hiển thị thông báo lỗi
    //     $this->js("toastr.error('Thông tin đăng nhập không chính xác')");
    // }

    public function login()
    {
        try {
            $this->validate();

            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                Log::logAction(auth()->id(), 'Đã đăng nhập vào hệ thống !');
                return $this->redirect(request()->header('Referer', '/'), navigate: true);
            }

            // Nếu thất bại, hiển thị thông báo lỗi
            $this->js("toastr.error('Thông tin đăng nhập không chính xác')");
        } catch (\Exception $e) {
            // Hiển thị thông báo lỗi ra giao diện với chi tiết thông báo lỗi
            $this->js("toastr.error('Lỗi: " . addslashes($e->getMessage()) . "')");
        }
    }


    public function render()
    {
        return view('client.partials.auth.login');
    }
}
