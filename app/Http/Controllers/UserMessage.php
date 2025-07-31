<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMessage
{

    /**
     * @param Authenticatable|null $user
     * @param mixed $subject
     * @param mixed $message
     */
    public function __construct(?Authenticatable $user, mixed $subject, mixed $message)
    {
    }
}
