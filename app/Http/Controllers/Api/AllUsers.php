<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Good;
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AllUsers extends Controller
{
    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */

    public function info(ModelsUser $user): JsonResponse
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();

        $liked = $user->likedGoods()->pluck('goods.id');

        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }

        $comments = Comment::query()
            ->with('user')
            ->where('user_id', $user->id)
            ->paginate(5);

        $goods = $user->goods()->paginate(5);

        $allGoods = Good::all();

        $items = $goods->getCollection()->map(function ($item) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $item->pivot;

            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $pivot->quantity,
            ];
        });

        $totalSum = $user->goods->sum(function ($item) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $item->pivot;

            return $item->price * $pivot->quantity;
        });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'created_at' => optional($user->created_at)->toDateTimeString(),
                'content' => $user->content ?? null,
            ],
            'comments' => [
                'data' => $comments->items(),
                'meta' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'total' => $comments->total(),
                ],
            ],
            'goods' => [
                'data' => $items,
                'totalSum' => $totalSum,
                'liked_ids' => $liked,
                'allGoods' => $allGoods,
                'meta' => [
                    'current_page' => $goods->currentPage(),
                    'last_page' => $goods->lastPage(),
                    'total' => $goods->total(),
                ],
            ],
        ]);
    }
}
