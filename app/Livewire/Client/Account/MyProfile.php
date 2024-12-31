<?php

namespace App\Livewire\Client\Account;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MyProfile extends Component
{
    public $display_name;
    public $email;
    public $current_password;
    public $new_password;
    public $confirm_password;

    protected $rules = [
        'display_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'current_password' => 'nullable|string|min:6',
        'new_password' => ['nullable', 'string', 'min:6', 'different:current_password'],
        'confirm_password' => 'nullable|same:new_password',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->display_name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        // Update display name and email
        $user->name = $this->display_name;
        $user->email = $this->email;

        // Update password if provided
        if ($this->current_password && $this->new_password) {
            if (Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Mật khẩu hiện tại không chính xác.');
                return;
            }
            $user->password = bcrypt($this->new_password);
        }

        $user->save();

        $this->js("toastr.success('Thông tin tài khoản đã được cập nhật thành công!')");
    }

    public function render()
    {
        return view('livewire.client.account.my-profile')
        ->extends('client.account.layout')
        ->section('main')
        ->layoutData(['title' => 'Hồ sơ của tôi']);
    }
}
