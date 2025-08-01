<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\User as ModelsUser;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserInfoApiController extends Controller
{
    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */
    public function show(ModelsUser $user): JsonResponse
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

        $items = $goods->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $item->pivot->quantity,
            ];
        });

        $totalSum = $user->goods->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        });

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'created_at' => $user->created_at->toDateTimeString(),
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
