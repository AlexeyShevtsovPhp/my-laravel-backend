<?php

namespace App\Http\Controllers\Api;

use App\Models\Good;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GoodApiController extends Controller
{
    /**
     * Создать комментарий.
     */
    public function show(int $category_id): JsonResponse
    {
        $user = Auth::user();

        $allGoods = Good::all();

        $goods = Good::where('category_id', $category_id)->get();
        $liked = $user->likedGoods()->pluck('goods.id');

        return response()->json([
            'goods' => $goods,
            'liked_ids' => $liked,
            'allGoods' => $allGoods,
        ]);
    }
}

