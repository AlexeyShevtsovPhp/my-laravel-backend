<?php

namespace App\Http\Controllers;

class Authorization extends Controller
{
    public function load(): object
    {
        return view('login');
    }
}
