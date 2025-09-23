<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest as Request;
use App\Http\Resources\UserRegistrationResource;
use Random\RandomException;
use App\Services\UserService;

class Registration extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * @throws RandomException
     */
    public function create(Request $request): UserRegistrationResource
    {
        /** @var array{name: string, password: string} $validatedData */
        return new UserRegistrationResource($this->userService->registerNewUser($request->validated()));
    }
}
