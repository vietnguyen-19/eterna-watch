<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class StaffAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Kiểm tra nếu user chưa đăng nhập hoặc không phải admin (role_id != 1)
         if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/admin/login')->with('error', 'Bạn không có quyền truy cập trang nhân viên.');
        }

        return $next($request);
    }
}
