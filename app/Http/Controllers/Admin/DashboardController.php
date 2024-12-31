<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $resourceDir = 'admin.dashboard';
    public function index(){
        return view($this->resourceDir . '.index');
    }
}
