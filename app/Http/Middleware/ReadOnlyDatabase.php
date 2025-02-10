<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ReadOnlyDatabase
{
    public function handle($request, Closure $next)
    {
        DB::beginTransaction();
        $response = $next($request);
        DB::rollBack(); // Tự động rollback mọi thay đổi
        return $response;
    }
}
