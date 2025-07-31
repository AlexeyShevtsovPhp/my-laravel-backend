<?php

namespace App\Http\Controllers;

class Registration extends Controller
{
    public function load(): object
    {
        return view('registration');
    }
}
