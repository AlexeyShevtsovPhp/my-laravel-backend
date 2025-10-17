<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Response;
use Random\RandomException;
use App\Services\UserService;

class RegistrationController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(public UserService $userService)
    {
    }

    /**
     * @throws RandomException
     */
    public function create(RegistrationRequest $registrationRequest): Response
    {
        /** @var array{name: string, password: string} $validatedData */
        $validatedData = $registrationRequest->validated();
        $this->userService->registerNewUser($validatedData);

        return response()->noContent();
    }
}
