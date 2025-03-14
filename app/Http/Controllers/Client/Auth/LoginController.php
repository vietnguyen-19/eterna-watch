<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
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

        // Kiểm tra đăng nhập
        if (Auth::attempt($validated)) {
            $user = Auth::user();

            if ($user->role_id == 3) {
                return redirect()->route('client.home');
            }

            Auth::logout();
            return redirect()->route('client.home')->withErrors(['email' => 'Bạn không có quyền truy cập.']);
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('client.home');
    }
}
