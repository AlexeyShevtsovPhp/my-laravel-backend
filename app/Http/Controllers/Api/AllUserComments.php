<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullComments;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

class AllUserComments extends Controller
{
    /**
     * @param ModelsUser $user
     * @return UserFullComments
     */
    public function info(ModelsUser $user): UserFullComments
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();

        if ($userSelf->role !== Status::ADMIN->value  && $user->id !== $userSelf->id) {
            abort(403, 'Доступ запрещён');
        }

        return new UserFullComments($user);
    }
}
