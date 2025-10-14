<?php

declare(strict_types=1);

namespace App\Repositories\Good;

use App\Models\Good;
use App\Models\User;
use LaravelEasyRepository\Repository;

interface GoodRepository extends Repository
{
    /**
     * @param int $categoryId
     * @param User $user
     * @return array<Good>
     */
    public function getGoodsByCategoryWithLikes(int $categoryId, User $user): array;

    public function existsByName(string $name): bool;

    /**
     * @param mixed $id
     * @param array<string, mixed> $data
     * @return Good
     */
    public function update(mixed $id, array $data): Good;
}
