<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Http\Resources\ToggleLikeResource;
use App\Models\Good;
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
        return new ToggleLikeResource($this->userRepository->toggleLike(Auth::user(), $good));
    }
}
