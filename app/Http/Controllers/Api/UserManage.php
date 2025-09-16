<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use App\Repositories\User\UserRepository;

class UserManage extends Controller
{
    /**
     * @return void
     */

    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function index(): JsonResponse
    {
        $users = $this->userRepository->all();
        return response()->json(['users' => UserResource::collection($users),]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = $this->userRepository->findByName($credentials['name']);

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return response()->json('', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(new AuthResource($user, $token));
    }

    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        if ($user->role === 'admin') {
            return response()->json('', 403);
        }

        $this->userRepository->delete($user->id);
        return response()->json('', 204);
    }
}
