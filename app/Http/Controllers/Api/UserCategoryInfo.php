<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCategoryPageResource;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;

class UserCategoryInfo extends Controller
{
    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */

    public function info(ModelsUser $user): JsonResponse
    {
        return response()->json(new UserCategoryPageResource($user));
    }
}
