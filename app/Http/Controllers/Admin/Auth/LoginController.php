<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // ✅ Validate dữ liệu đầu vào
        $validated = $request->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ], [
            'email.required'    => 'Email không được để trống.',
            'email.email'       => 'Email không hợp lệ.',
            'email.max'         => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.max'      => 'Mật khẩu không được vượt quá 255 ký tự.',
        ]);

        // ✅ Thử đăng nhập với guard admin
        if (Auth::guard('admin')->attempt($validated)) {
            $user = Auth::guard('admin')->user();

            // ✅ Chỉ cho phép role_id 1 (admin) hoặc 2 (nhân viên)
            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard.revenue');
            } elseif ($user->role_id == 2) {
                return redirect()->route('admin.orders.index');
            }


            // 🚫 Không có quyền truy cập => đăng xuất
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Tài khoản của bạn không được phép truy cập trang quản trị.'
            ]);
        }

        // ❌ Sai thông tin đăng nhập
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.'
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
