<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Random\RandomException;

class Registration extends Controller
{
    /**
     * @param Request $request
     * @return object
     * @throws ValidationException
     * @throws RandomException
     */
    public function create(Request $request): object
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return redirect('/registration?registered=false');
        }

        $validated = $validator->validated();

        $username = $validated['name'];
        $password = $validated['password'];

        $user = User::query()
            ->where('name', $username)
            ->first();

        if ($user) {
            return redirect('/registration?error=taken');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        User::create([
            'name' => $username,
            'password' => $hashedPassword,
            'created_at' => now(),
            'role' => 'guest',
            'email' => 'user' . bin2hex(random_bytes(5)) . '@mail.com',
            'email_verified_at' => now(),
        ]);

        return redirect('/registration?registered=true');
    }
}
