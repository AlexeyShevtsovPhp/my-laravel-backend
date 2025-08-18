<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullCart;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

class AllUserCart extends Controller
{
    /**
     * @param ModelsUser $user
     * @return UserFullCart
     */

    public function info(ModelsUser $user): UserFullCart
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();

        if ($userSelf->role !== Status::ADMIN  && $user->id !== $userSelf->id) {
            abort(403, 'Доступ запрещён');
        }

        return new UserFullCart($user);
    }
}
