<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Good;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Like extends Controller
{
    /**
     * @param Good $good
     * @return JsonResponse
     */

    public function toggleLike(Good $good): JsonResponse
    {
        /** @var User $user */

        $user = Auth::user();
        $liked = $user->addLike($good);

        return response()->json(['success' => true, 'liked' => $liked]);
    }
}
