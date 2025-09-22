<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullCart;
use App\Models\User as ModelsUser;

class AllUserCart extends Controller
{
    /**
     * @param ModelsUser $user
     * @return UserFullCart
     */
    public function info(ModelsUser $user): UserFullCart
    {
        return new UserFullCart($user);
    }
}
