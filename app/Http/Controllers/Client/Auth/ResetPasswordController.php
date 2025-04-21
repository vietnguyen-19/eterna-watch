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
        // Thực hiện validate yêu cầu
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'token.required' => 'Vui lòng cung cấp mã xác nhận.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        try {
            // Thực hiện reset mật khẩu
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
        } catch (\Exception $e) {
            // Nếu xảy ra lỗi, trả về thông báo lỗi
            return back()->withErrors(['email' => 'Đã xảy ra lỗi trong quá trình đặt lại mật khẩu. Vui lòng thử lại sau. Lỗi: ' . $e->getMessage()]);
        }
    }
}
