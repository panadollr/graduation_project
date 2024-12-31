<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $resourceDir = 'admin.auth';
    public function index(){
        return view($this->resourceDir . '.index');
    }

    public function logout(){
        Auth::logout();
        session()->forget('admin');
        return redirect()->route('admin.login')->with('message', 'Bạn đã đăng xuất thành công.');
    }
}
