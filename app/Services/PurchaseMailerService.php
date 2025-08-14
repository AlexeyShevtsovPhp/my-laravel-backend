<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PurchaseMailerService
{
    public function sendPurchaseConfirmation(User $user, string $message): void
    {
        Mail::raw($message, function ($mail) use ($user) {
            $mail->from('laravelShop@gmail.com');
            $mail->to($user->email, $user->name)
                ->subject('Спасибо за покупку');
        });
    }
}
