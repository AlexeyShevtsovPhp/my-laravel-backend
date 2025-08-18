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

class UserFullComments extends JsonResource
{
    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        JsonResource::withoutWrapping();

        $comments = $this->resource->comments()
            ->paginate(5, ['*'], 'page', request()->query('page', 1));

        return [
            'user' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'role' => $this->resource->role,

                'comments' => [
                    'data' => UserCommentResource::collection($comments),
                    'meta' => [
                        'current_page' => $comments->currentPage(),
                        'last_page' => $comments->lastPage(),
                        'total' => $comments->total(),
                    ],
                    'cart_items_count' => (int)$this->resource->goods()->sum('quantity'),
                ],
            ],
        ];
    }
}
