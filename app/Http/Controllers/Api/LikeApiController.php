<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Good;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class LikeApiController extends Controller
{
    /**
     * @param Good $good
     * @return JsonResponse
     */
    public function toggleLike(Good $good): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->likedGoods()->where('good_id', $good->id)->exists()) {
            $user->likedGoods()->detach($good->id);

            return response()->json(['success' => true, 'liked' => false]);
        } else {
            $user->likedGoods()->attach($good->id);

            return response()->json(['success' => true, 'liked' => true]);
        }
    }
}
