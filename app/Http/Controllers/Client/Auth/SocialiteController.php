<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    // Điều hướng đến Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Tìm người dùng trong hệ thống qua email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user);

            // Kiểm tra nếu người dùng chưa xác minh email thì tự động xác minh
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                // Có thể gửi thông báo xác minh lại hoặc thông báo đã xác minh thành công
            }

            return redirect()->route('client.home');
        }

        return redirect()->route('client.login')->withErrors(['email' => 'Không tìm thấy người dùng']);
    }
}
