<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCategoryPageResource;
use App\Models\User;

class UserCategoryInfo extends Controller
{
    /**
     * @param User $user
     * @return UserCategoryPageResource
     */
    public function info(User $user): UserCategoryPageResource
    {
        return new UserCategoryPageResource($user);
    }
}
