<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $resourceDir = 'client.account';
    public function index(){
        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Tổng số lượng đơn hàng đã mua
        $totalOrders = Order::where('user_id', $user->id)->count();

        // Tổng tiền đã chi tiêu
        $totalSpent = Order::where('user_id', $user->id)
            ->where('status', 'completed') // Chỉ tính các đơn hàng đã hoàn thành
            ->sum('total_price');

        // Chi tiêu trung bình mỗi đơn hàng
        $averageSpent = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;

        // Đơn hàng gần đây (lấy 5 đơn hàng mới nhất)
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Trả về view với dữ liệu
        return view($this->resourceDir . '.index', compact(
            'totalOrders',
            'totalSpent',
            'averageSpent',
            'recentOrders'
        ));
    }

    public function logout(){
        Auth::logout();
        session()->forget('user');
        return back()->with('message', 'Bạn đã đăng xuất thành công!');
    }

}
