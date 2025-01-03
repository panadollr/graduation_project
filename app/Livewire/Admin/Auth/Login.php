<?php

namespace App\Livewire\Admin\Auth;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false; // Để lưu thông tin người dùng
    public $isLoading = false;

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


    public function login()
    {
        $this->validate();
        $this->isLoading = true;
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();
            Session::put('admin', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'authenticated' => true
            ]);
            Log::logAction(auth()->id(), 'Đã đăng nhập vào hệ thống !');
            return $this->redirect(route('admin.dashboard'));
        } else {
            // Nếu thông tin không chính xác
            $this->isLoading = false;
            session()->flash('error', 'Email hoặc mật khẩu không chính xác.');
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('admin.auth.components.form');
    }
}
