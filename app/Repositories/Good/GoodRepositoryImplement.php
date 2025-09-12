<?php

namespace App\Repositories\Good;

use App\Models\Good;
use App\Models\User;
use LaravelEasyRepository\Implementations\Eloquent;

class GoodRepositoryImplement extends Eloquent implements GoodRepository
{
    /**
     * @var Good
     */
    protected Good $model;

    public function __construct(Good $model)
    {
        $this->model = $model;
    }
    /**
     * @param int $categoryId
     * @param User $user
     * @return array<string, mixed>
     */
    public function getGoodsByCategoryWithLikes(int $categoryId, User $user): array
    {
        $goods = $this->model->where('category_id', $categoryId)->get();

        $liked = $user->likedGoods()->pluck('goods.id');

        return [
            'goods' => $goods,
            'liked_ids' => $liked,
        ];
    }

    public function existsByName(string $name): bool
    {
        return $this->model->where('name', $name)->exists();
    }
}
