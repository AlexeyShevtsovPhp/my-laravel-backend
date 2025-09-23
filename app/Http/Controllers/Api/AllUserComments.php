<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullComments;
use App\Models\User;

class AllUserComments extends Controller
{
    /**
     * @param User $user
     * @return UserFullComments
     */
    public function info(User $user): UserFullComments
    {
        return new UserFullComments($user);
    }
}
