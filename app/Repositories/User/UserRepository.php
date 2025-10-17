<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\Good;
use App\Models\User;
use LaravelEasyRepository\Repository;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository extends Repository
{
    public function findByName(string $name): ?User;

    public function toggleLike(User $user, Good $good): bool;

    /**
     * @param User $user
     * @return Collection<int, Good>
     */
    public function getCartItems(User $user): Collection;

    public function addToCart(User $user, int $productId): int;

    public function removeFromCart(User $user, int $productId): bool;

    public function clearCart(User $user): void;
}
