<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Good;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @property Collection<int, Good> $allGoods
 * @property Collection<int, int> $liked
 *
 * @property LengthAwarePaginator<int, Comment> $comments
 * @property LengthAwarePaginator<int, Good> $goods
 */

class UserFullCart extends JsonResource
{
    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        JsonResource::withoutWrapping();

        $goods = $this->resource->goods()->paginate(5);
        $commentsCount = Comment::query()->where('user_id', $this->resource->id)->count();
        $totalSum = $this->resource->getTotalGoodsSum();
        $liked = LikedResource::collection($this->resource->likedGoods);

        return [
            'user' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'role' => $this->resource->role,

                'comments_count' => $commentsCount,
                'total_sum' => $totalSum,

                'goods' => [
                    'data' => [
                        'cart' => UserGoodResource::collection($goods),
                        'liked' => $liked,
                    ],
                    'meta' => [
                        'current_page' => $goods->currentPage(),
                        'last_page' => $goods->lastPage(),
                        'total' => $goods->total(),
                    ],
                ],
            ],
        ];
    }
}
