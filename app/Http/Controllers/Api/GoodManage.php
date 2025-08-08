<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Good;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GoodManage extends Controller
{

    /**
     * @param int $category_id
     * @return JsonResponse
     */

    public function show(int $category_id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $allGoods = Good::all();

        $goods = Good::query()
            ->where('category_id', $category_id)->get();
        $liked = $user->likedGoods()->pluck('goods.id');

        return response()->json([
            'goods' => $goods,
            'liked_ids' => $liked,
            'allGoods' => $allGoods,
        ]);
    }
}
