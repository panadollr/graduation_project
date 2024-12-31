<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;

class UserEditor extends Component
{
    public $userData = [
        'name' => '', 
        'email' => '',
        'password' => '',
        'role' => ''
    ];

    public $userId = null;

    protected $rules = [
        'userData.name' => 'required|string|max:255',
        'userData.email' => 'required|email|max:255',
        'userData.password' => 'required|string|min:6',
        'userData.phone' => 'nullable|string|max:15',
        'userData.address' => 'nullable|string|max:255',
        'userData.role' => 'required|string|in:admin,employee,user'
    ];    

    public function messages()
    {
        return [
            'userData.name.required' => 'Tên người dùng là bắt buộc.',
            'userData.name.string' => 'Tên người dùng phải là chuỗi ký tự.',
            'userData.name.max' => 'Tên người dùng không được dài quá 255 ký tự.',

            'userData.email.required' => 'Email là bắt buộc.',
            'userData.email.email' => 'Email không hợp lệ.',
            'userData.email.unique' => 'Email này đã tồn tại, vui lòng chọn email khác.',
            'userData.email.max' => 'Email không được dài quá 255 ký tự.',

            'userData.password.required' => 'Mật khẩu là bắt buộc.',
            'userData.password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'userData.password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'userData.phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'userData.phone.max' => 'Số điện thoại không được dài quá 15 ký tự.',

            'userData.address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'userData.address.max' => 'Địa chỉ không được dài quá 255 ký tự.',

            'userData.role.required' => 'Vai trò là bắt buộc.',
            'userData.role.in' => 'Vai trò không hợp lệ.',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->userData = $user->only(['name', 'email', 'password', 'role']);
        }
    }

    public function saveUser()
    {
        $this->rules['userData.email'] = $this->userId ? 
        'required|email|max:255|unique:users,email,' . $this->userId : 
        'required|email|max:255|unique:users,email';

        $this->validate();

        // Hash password if it is being set
        if ($this->userData['password']) {
            $this->userData['password'] = bcrypt($this->userData['password']);
        } else {
            unset($this->userData['password']); // If password is not being updated
        }

        // Create or update the User
        $user = $this->userId ? User::findOrFail($this->userId) : new User();
        $user->fill($this->userData);
        $user->save();

        session()->flash('success', $this->userId ? 'Cập nhật người dùng thành công' : 'Thêm người dùng thành công');
        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.admin.user.user-editor', [
            'title' => $this->userId ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới'
        ])
        ->extends('admin.app')
        ->layoutData(['title' => $this->userId ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới']);
    }
}
