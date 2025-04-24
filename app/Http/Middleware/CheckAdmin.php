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
        // Kiểm tra đăng nhập bằng guard 'admin'
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Lấy user từ guard admin
        $user = Auth::user();

        // Kiểm tra role_id
        $allowedRoles = [1, 2]; // Ví dụ: 1 = admin, 2 = super admin

        if (in_array($user->role_id, $allowedRoles)) {
            return $next($request);
        }

        // Nếu không có quyền, đăng xuất khỏi guard admin và chuyển hướng
        Auth::logout();
        return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập!');
    }
}
