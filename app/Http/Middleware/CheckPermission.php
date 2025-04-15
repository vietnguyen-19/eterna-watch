<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Kiểm tra đăng nhập và quyền
        if (!$user) {
            abort(403, 'Bạn cần đăng nhập để truy cập chức năng này!');
        }

        // Load mối quan hệ để tránh lỗi khi permissions chưa được eager load
        $user->loadMissing('role.permissions');

        if (!$user->hasPermission($permission)) {
            abort(403, 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
    
}
