<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PurchaseMailerService
{
    public function sendPurchaseConfirmation(User $user, string $messageHtml): void
    {
        Mail::send([], [], function ($mail) use ($user, $messageHtml) {
            $mail->from(config('mail.shopEmail'), config('mail.shopName'));
            $mail->to($user->email, $user->name)
                ->subject('Thank you for your purchase!')
                ->html($messageHtml);
        });
    }
}
