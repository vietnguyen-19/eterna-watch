<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Nếu chưa đăng nhập thì chuyển hướng
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Lấy user đã đăng nhập
        $user = Auth::guard('admin')->user();

        // Kiểm tra role_id hợp lệ
        if (!in_array($user->role_id, [1, 2])) {
            return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập');
        }

        return $next($request);
    }
}
