<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AdminLoginController extends Controller
{
    public function loginForm()
    {
        return view('admin.auth.login'); // Hiển thị form đăng nhập
    }

    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     Auth::login($user);

    //     return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    // }

    public function adminLogin(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Kiểm tra đăng nhập
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập

            // Chuyển hướng theo vai trò (role_id)
            switch ($user->role_id) {
                case 1:
                    return redirect()->route('admin.dashboard.revenue');  // Admin
                case 2:
                    return redirect()->route('staff.dashboard.revenue');  // Nhân viên
                case 3:
                    return redirect()->route('client.home'); // Khách hàng
                default:
                    Auth::logout();
                    return redirect()->route('user.login')->withErrors(['error' => 'Vai trò không hợp lệ!']);
            }
        }

        // Đăng nhập thất bại
        return back()->withErrors(['error' => 'Email hoặc mật khẩu không chính xác!']);
    }

    public function forgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function adminForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.home');
    }
}
