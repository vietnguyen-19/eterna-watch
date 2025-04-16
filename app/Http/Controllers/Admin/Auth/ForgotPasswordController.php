<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CustomResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user || !in_array($user->role_id, [1, 2])) {
            return back()->withErrors(['email' => 'Tài khoản không thuộc vai trò hợp lệ để đặt lại mật khẩu.']);
        }
        // Tạo token reset
        $token = Password::createToken($user);

        // Gửi notification custom
        $user->notify(new CustomResetPassword($token, $user->role_id));

        return back()->with('status', 'Link đặt lại mật khẩu đã được gửi đến email.');
    }
}
