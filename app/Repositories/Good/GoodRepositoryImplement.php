<?php

namespace App\Repositories\Good;

use App\Models\Good;
use App\Models\User;
use LaravelEasyRepository\Implementations\Eloquent;

class GoodRepositoryImplement extends Eloquent implements GoodRepository
{
    /**
     * @return void
     */

    public function __construct(protected Good $model)
    {
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

    /**
     * @param mixed $id
     * @param array<string, mixed> $data
     * @return Good
     */
    public function update(mixed $id, array $data): Good
    {
        /** @var Good $good */
        $good = $this->model->newQuery()->findOrFail($id);
        $good->fill($data);
        $good->save();

        return $good;
    }
}
