<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Kiểm tra nếu user đã đăng nhập và có role_id = 1
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request); // Cho phép tiếp tục
        }

        // Nếu không phải adminadmin, chuyển hướng về trang đăng nhập
        return redirect()->route('login');
    }
}
