<?php

namespace App\Mail;

use App\Models\Refund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefundApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }

    public function build()
    {
        return $this->subject('Yêu cầu hoàn tiền của bạn đã được chấp nhận')
                    ->view('emails.refund_approved');
    }
}
