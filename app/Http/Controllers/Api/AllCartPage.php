<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Enums\Status;
use App\Http\Resources\UserFullCartPage;
use App\Models\User as ModelsUser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class AllCartPage extends Controller
{
    public function info(ModelsUser $user): UserFullCartPage
    {
        {
            /** @var ModelsUser $userSelf */
            $userSelf = Auth::user();

            if ($userSelf->role !== Status::ADMIN->value && $user->id !== $userSelf->id) {
                abort(403, 'Доступ запрещён');
            }
            return new UserFullCartPage($user);
        }
    }
}
