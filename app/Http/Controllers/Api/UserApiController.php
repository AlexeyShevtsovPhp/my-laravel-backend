<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    /**
     * Логин пользователя и получение токена
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('name', $request->name)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
            'id' => $user->id,
            'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
                ]
        ]);
    }

    public function delete(ModelsUser $user)
    {
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Нельзя удалить администратора',
                'success' => false,], 403);
        }

        $user->delete();
        return response()->json([
            'message' => 'Пользователь успешно удалён',
            'success' => true,], 200);
    }

}
