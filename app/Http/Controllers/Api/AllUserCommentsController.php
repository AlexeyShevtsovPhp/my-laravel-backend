<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullCommentsResource;
use App\Models\User;

class AllUserCommentsController extends Controller
{
    /**
     * @param User $user
     * @return UserFullCommentsResource
     */
    public function info(User $user): UserFullCommentsResource
    {
        return new UserFullCommentsResource($user);
    }
}
