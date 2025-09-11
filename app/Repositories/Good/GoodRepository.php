<?php

namespace App\Repositories\Good;

use App\Models\User;
use LaravelEasyRepository\Repository;

interface GoodRepository extends Repository
{
    /**
     *
     * @param int $categoryId
     * @param User $user
     * @return array<string, mixed>
     */
    public function getGoodsByCategoryWithLikes(int $categoryId, User $user): array;

    public function existsByName(string $name): bool;
}
