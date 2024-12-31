<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name; // Tên tài khoản
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|same:password',
        'password_confirmation' => 'required|same:password',
    ];

    protected $messages = [
        'name.required' => 'Vui lòng nhập tên.',
        'name.string' => 'Tên phải là chuỗi ký tự.',
        'name.max' => 'Tên không được vượt quá :max ký tự.',
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không đúng định dạng.',
        'email.unique' => 'Email đã được sử dụng.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        'password_confirmation.same' => 'Mật khẩu xác nhận không khớp.',
    ];
    

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'user'
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('client.partials.auth.register');
    }
}
