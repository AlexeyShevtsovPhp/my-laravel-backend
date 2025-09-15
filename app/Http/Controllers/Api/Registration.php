<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserRegistrationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Random\RandomException;
use App\Services\UserService;

class Registration extends Controller
{
    /**
     * @throws ValidationException
     * @throws RandomException
     */
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
    }
    /**
     * @throws RandomException
     */
    public function create(RegistrationRequest $request): JsonResponse
    {
        /** @var array{name: string, password: string} $validatedData */
        $validatedData = $request->validated();

        $user = $this->userService->registerNewUser($validatedData);

        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'user' => new UserRegistrationResource($user),
        ], 201);
    }
}
