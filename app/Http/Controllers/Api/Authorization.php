<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Authorization extends Controller
{
    /**
     * @param Request $request
     * @return object
     * @throws ValidationException
     */
    public function enter(Request $request): object
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return redirect('/login?registered=false');
        }


        $validated = $validator->validated();
        $user = User::query()
            ->where('name', $validated['user'])
            ->first();
        if (!$user || !password_verify($validated['password'], $user->password)) {
            return redirect('/login?registered=false');
        }

        Auth::login($user);

        return redirect('/categories/1?page=1');
    }
}
