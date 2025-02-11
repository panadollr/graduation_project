<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReadOnlyDatabase
{
    // public function handle($request, Closure $next)
    // {
    //     DB::beginTransaction();
    //     $response = $next($request);
    //     DB::rollBack(); // Tự động rollback mọi thay đổi
    //     return $response;
    // }

    public function handle($request, Closure $next)
    {
        // Kiểm tra xem yêu cầu có phải là các thao tác ghi vào cơ sở dữ liệu (INSERT, UPDATE, DELETE)
        $method = $request->method();
        $isWriteOperation = in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE']);

        if ($isWriteOperation) {
            // Nếu là thao tác ghi, thêm thông báo và rollback
            return Response::json([
                'error' => 'Quản trị viên đã chặn thao tác ghi dữ liệu trong chế độ chỉ đọc.'
            ], 403); // Trả về lỗi 403 (Forbidden)
        }

        // Nếu không phải thao tác ghi, tiếp tục xử lý request
        DB::beginTransaction();
        $response = $next($request);
        DB::rollBack(); // Tự động rollback mọi thay đổi
        return $response;
    }
}
