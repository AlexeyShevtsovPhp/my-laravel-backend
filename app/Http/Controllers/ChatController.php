<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $message = $request->input('message');

        event(new MessageSent($message));

        return response()->json(['status' => 'Событие отправлено']);
    }
}
