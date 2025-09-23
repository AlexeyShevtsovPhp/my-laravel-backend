<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class FeedbackService
{
    /**
     * @param array{message: string, email: string, name: string, subject: string} $data
     */
    public function sendFeedback(array $data): void
    {
        Mail::raw($data['message'], function ($mail) use ($data) {
            $mail->from($data['email'], $data['name']);
            $mail->to(config('mail.shopKeeperEmail'))
                ->subject('Guest message: ' . $data['subject'])
                ->replyTo($data['email'], $data['name']);
        });
    }
}
