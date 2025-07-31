<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Account extends Controller
{
    public function load(): object
    {
        $user = Auth::user();

        return view(
            'account',
            [
                'date' => $user->created_at,
                'name' => $user->name,
                'role' => $user->role,
                'user_id' => $user->id,
            ],
        );
    }
}
