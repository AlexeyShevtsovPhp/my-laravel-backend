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

class UserFullInfoResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        JsonResource::withoutWrapping();

        $comments = $this->resource->comments;
        $goods = $this->resource->goods;
        $liked = $this->resource->liked;
        $totalSum = $this->resource->totalSum;
        $allGoods = $this->resource->allGoods;

        return [
            'user' => new UserResource($this),
            'comments' => [
                'data' => UserCommentResource::collection($comments),
                'meta' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'total' => $comments->total(),
                ],
            ],
            'goods' => [
                'data' => UserGoodResource::collection($goods),
                'totalSum' => $totalSum,
                'liked_ids' => $liked,
                'allGoods' => $allGoods,
                'meta' => [
                    'current_page' => $goods->currentPage(),
                    'last_page' => $goods->lastPage(),
                    'total' => $goods->total(),
                ],
            ],
        ];
    }
}
