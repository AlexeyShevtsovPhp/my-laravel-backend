<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Good;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @property Collection<int, Good> $allGoods
 * @property Collection<int, int> $liked
 * @property LengthAwarePaginator<int, Comment> $comments
 * @property LengthAwarePaginator<int, Good> $goods
 */
class UserCategoryPageResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        JsonResource::withoutWrapping();

        $goodsCount = $this->resource->goods()->count();

        return [
            'info' => [
                    'goods_count' => $goodsCount,
            ],
        ];
    }
}
