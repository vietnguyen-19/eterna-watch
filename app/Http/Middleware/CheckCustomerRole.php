<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu user đã đăng nhập và có role_id = 3
        if (Auth::check() && Auth::user()->role_id == 3) {
            return $next($request); // Cho phép tiếp tục
        }

        // Nếu không phải customer, chuyển hướng về trang đăng nhập
        return redirect()->route('client.login');
    }
}
