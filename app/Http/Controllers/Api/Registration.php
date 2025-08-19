<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserRegistrationResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Random\RandomException;

class Registration extends Controller
{
    /**
     * @throws ValidationException
     * @throws RandomException
     */
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws RandomException
     * @throws ValidationException
     */

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
            'role' => 'guest',
            'email' => 'user'.bin2hex(random_bytes(5)).'@mail.com',
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'user' => new UserRegistrationResource($user),
        ], 201);
    }
}
