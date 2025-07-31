<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{

    function logout(): object
    {
        Auth::logout();

        return view('login');
    }
}
