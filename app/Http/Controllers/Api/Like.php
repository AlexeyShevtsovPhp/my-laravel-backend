<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Resources\ToggleLikeResource;
use App\Models\Good;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Like extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    /**
     * @param Good $good
     * @return ToggleLikeResource
     */
    public function toggleLike(Good $good): ToggleLikeResource
    {
        /** @var User $user */
        $user = Auth::user();
        $liked = $this->userRepository->toggleLike($user, $good);

        return new ToggleLikeResource($liked);
    }
}
