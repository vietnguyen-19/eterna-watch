<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('client.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Nếu reset thành công, chuyển hướng về trang đăng nhập và hiển thị thông báo thành công
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('client.login')->with('status', 'Mật khẩu của bạn đã được đặt lại thành công! Vui lòng đăng nhập.')
            // Nếu có lỗi, quay lại trang trước và hiển thị lỗi
            : back()->withErrors(['email' => [__($status)]]);
    }
}
