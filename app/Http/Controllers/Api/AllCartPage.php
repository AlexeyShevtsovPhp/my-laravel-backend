<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Resources\UserFullCartPage;
use App\Models\User;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class AllCartPage extends Controller
{
    public function info(User $user): UserFullCartPage
    {
        {
            return new UserFullCartPage($user);
        }
    }
}
