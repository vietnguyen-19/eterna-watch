<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
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
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('client.home');
    }

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
