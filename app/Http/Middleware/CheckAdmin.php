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
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('admin.login'); // Chuyển hướng nếu chưa đăng nhập
        }

        // Kiểm tra quyền admin
        $userRole = Auth::user()->role_id;
        $allowedRoles = [1, 2]; // Mảng quyền cho phép (ví dụ: 1 là admin, 2 là super admin)
        
        if (in_array($userRole, $allowedRoles)) {
            return $next($request); // Nếu người dùng có quyền admin, tiếp tục request
        }

        // Nếu không có quyền, chuyển hướng về trang login
        return redirect()->route('admin.login'); 
    }
}
