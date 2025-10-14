<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullCart;
use App\Models\User;

class AllUserCartController extends Controller
{
    /**
     * @param User $user
     * @return UserFullCart
     */
    public function info(User $user): UserFullCart
    {
        return new UserFullCart($user);
    }
}
