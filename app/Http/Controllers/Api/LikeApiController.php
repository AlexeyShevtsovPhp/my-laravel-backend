<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Good;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class LikeApiController extends Controller
{

    public function toggleLike(Good $good): JsonResponse
    {
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
