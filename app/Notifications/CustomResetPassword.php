<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    public $token;
    public $role;

    public function __construct($token, $role = 3)
    {
        $this->token = $token;
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Phân biệt link theo vai trò
        $url = url(
            $this->role === 1 || $this->role === 2
                ? "/admin/reset-password/{$this->token}?email={$notifiable->getEmailForPasswordReset()}"
                : "/reset-password/{$this->token}?email={$notifiable->getEmailForPasswordReset()}"
        );

        return (new MailMessage)
            ->subject('Yêu cầu đặt lại mật khẩu')
            ->line('Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->action('Đặt lại mật khẩu', $url)
            ->line('Nếu bạn không yêu cầu, không cần làm gì thêm.');
    }
}
