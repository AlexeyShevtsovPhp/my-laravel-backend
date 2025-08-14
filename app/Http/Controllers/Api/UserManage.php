<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserManage extends Controller
{
    /**
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        $usersPerPage = ModelsUser::PER_PAGE;
        $users = ModelsUser::query()->paginate($usersPerPage);

        $meta = [
            'total' => $users->total(),
            'max_per_page' => $usersPerPage,
            'total_pages' => $users->lastPage(),
        ];
        return response()->json([
            'users' => UserResource::collection($users->items()),
            'meta' => $meta,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('name', $request->name)->first();

        if (! $user || ! password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */

    public function delete(ModelsUser $user): JsonResponse
    {
        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Нельзя удалить администратора',
                'success' => false, ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'Пользователь успешно удалён',
            'success' => true, ], 200);
    }
}
