<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('Admin.settings.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Validate thông tin đăng nhập
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cố gắng đăng nhập
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->remember)) {
            // Nếu đăng nhập thành công, chuyển hướng đến trang trước đó hoặc trang mặc định
            return redirect()->intended(route('admin.dashboard'));
        }

        // Nếu đăng nhập thất bại, quay lại form đăng nhập với thông báo lỗi
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
