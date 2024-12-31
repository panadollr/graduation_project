<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $resourceDir = 'admin.user';
    public function index(){
        return view($this->resourceDir . '.index');
    }

    public function create(){
        return view($this->resourceDir . '.create&edit.create');
    }

    public function edit(){
        return view($this->resourceDir . '.create&edit.edit');
    }
}
