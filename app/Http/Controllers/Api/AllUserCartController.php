<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullCartResource;
use App\Models\User;

class AllUserCartController extends Controller
{
    /**
     * @param User $user
     * @return UserFullCartResource
     */
    public function info(User $user): UserFullCartResource
    {
        return new UserFullCartResource($user);
    }
}
