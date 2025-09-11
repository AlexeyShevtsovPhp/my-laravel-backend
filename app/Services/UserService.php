<?php

namespace App\Services;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Random\RandomException;
use App\Models\User;

class UserService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param array{name: string, password: string} $validatedData // <-- Вот так правильно
     * @return User
     * @throws RandomException
     */

    public function registerNewUser(array $validatedData): User
    {
        $userDataToCreate = [
            'name' => $validatedData['name'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'guest', //
            'email' => 'user' . bin2hex(random_bytes(5)) . '@mail.com',
            'email_verified_at' => now(),
        ];
        /** @var User $user */

        $user = $this->userRepository->create($userDataToCreate);

        return $user;
    }
}
