<?php

namespace App\Http\Resources;

use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodWithLikesResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array{goods: array<int, array{id: int, name: string, price: float|int}>, liked_ids: array<int>}
     * @property array{goods: Good[], liked_ids: int[]} $resource
     */
    public function toArray(Request $request): array
    {
        /** @var Good[] $goods */
        $goods = $this->resource['goods'];

        return [
            'goods' => collect($goods)->map(function (Good $good) {
                return [
                    'id' => $good->id,
                    'name' => (string) $good->name,
                    'price' => $good->price,
                ];
            })->all(),
            'liked_ids' => $this->resource['liked_ids'],
        ];
    }
}
