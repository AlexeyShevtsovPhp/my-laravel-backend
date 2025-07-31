<?php

namespace App\Http\Controllers\Monolit;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Feedback extends Controller
{

    function index(): object
    {
        $user = Auth::user();
        $button = '';

        switch ($user->role) {
            case 'admin':
                $path = "/images/userIcon/admin.png";
                $button = 'active';
                break;
            case 'guest':
                $path = "/images/userIcon/guest.png";
                $button = 'not-active';
                break;
            default:
                $path = '';
        }
        return view('monolit/feedBack', [
            'button' => $button,
            'user' => $user,
            'path' => $path,
        ]);
    }

    function send(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subject = $request->input('subject');
        $message = $request->input('message');
        $to = 'shautsou.aliaksei@innowise.com';

        $emailContent = "Сообщение от: {$user->name} ({$user->email})\n\n";
        $emailContent .= "Тема: {$subject}\n\n";
        $emailContent .= "Сообщение:\n{$message}";

        Mail::raw($emailContent, function ($message) use ($to, $subject) {
            $message->to($to)
                ->subject($subject);
        });

        return back()->with('success', 'Сообщение отправлено!');

    }

}
