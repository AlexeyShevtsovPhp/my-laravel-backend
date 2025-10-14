<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserManageController extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function index(): UserCollection
    {
        return new UserCollection($this->userRepository->all());
    }

    /**
     * @param LoginRequest $loginRequest
     * @return JsonResponse|AuthResource
     */
    public function login(LoginRequest $loginRequest): JsonResponse|AuthResource
    {
        if (!Auth::attempt($loginRequest->validated())) {
            return response()->json(null, 401);
        }
        /** @var User $user */
        $user = Auth::user();
        return new AuthResource($user, $user->createToken('auth_token')->plainTextToken);
    }

    /**
     * @param User $user
     * @return Response
     */
    public function delete(User $user): Response
    {
        $this->userRepository->delete($user->id);
        return response()->noContent();
    }
}
