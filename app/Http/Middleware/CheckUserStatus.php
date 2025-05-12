<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserStatus
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
    // Kiểm tra tài khoản admin
    if (Auth::guard('admin')->check()) {
        $user = Auth::guard('admin')->user();
        if ($user->status === 'inactive') {
            Auth::guard('admin')->logout();
            Session::put('account_disabled', true);
            return redirect()->route('admin.login'); // hoặc route phù hợp với trang đăng nhập admin
        }
    }

    // Kiểm tra tài khoản thường
    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
        if ($user->status === 'inactive') {
            Auth::guard('web')->logout();
            Session::put('account_disabled', true);
            return redirect()->route('client.login'); // chuyển về route đăng nhập
        }
    }

    return $next($request);
}

} 