<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Hiển thị thông báo yêu cầu người dùng xác minh email.
     *
     * @return \Illuminate\View\View
     */
    public function showVerificationNotice()
    {
        return view('client.auth.verify-email');
    }

    /**
     * Xử lý yêu cầu xác minh email.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        // Lấy ID và hash từ query string
       
        $userId = $request->route('id');
        $hash = $request->route('hash');
       
        // Lấy user theo ID
        $user = User::find($userId);

        // Kiểm tra nếu không tìm thấy người dùng
        if (!$user) {
            return redirect()->route('client.login')->withErrors(['email' => 'Người dùng không tồn tại hoặc liên kết không hợp lệ.']);
        }

        // Kiểm tra nếu email đã được xác minh
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('client.login')->with('message', 'Email đã được xác minh.');
        }

        // Kiểm tra tính hợp lệ của hash
        $expectedHash = sha1($user->getEmailForVerification());
        if (!hash_equals($expectedHash, $hash)) {
            return redirect()->route('client.login')->withErrors(['email' => 'Liên kết xác minh không hợp lệ.']);
        }

        // Xác minh email của người dùng
        $user->markEmailAsVerified();

        // Quay lại trang login sau khi xác minh thành công
        return redirect()->route('client.login')->with('message', 'Xác minh email thành công!');
    }

    /**
     * Gửi lại email xác minh cho người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * Gửi lại email xác minh cho người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationLink(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link xác minh đã được gửi!');
    }
}
