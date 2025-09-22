<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullComments;
use App\Models\User as ModelsUser;

class AllUserComments extends Controller
{
    /**
     * @param ModelsUser $user
     * @return UserFullComments
     */
    public function info(ModelsUser $user): UserFullComments
    {
        return new UserFullComments($user);
    }
}
