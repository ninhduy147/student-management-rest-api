<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Nếu không có user
        if (! $user) {
            return response()->json([
                'status' => 401,
                'message' => 'Bạn chưa đăng nhập',
            ], 401);
        }

        // Cho phép admin truy cập mọi route
        if ($user->role === 'admin' || in_array($user->role, $roles)) {
            return $next($request);
        }

        return response()->json([
            'status' => 403,
            'message' => 'Bạn không có quyền truy cập',
        ], 403);
    }

}
