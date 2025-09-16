<?php

namespace App\Repositories\User;

use App\Models\Good;
use Illuminate\Database\Eloquent\Relations\Pivot;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    /**
     * @property User $model;
     */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByName(string $name): ?User
    {
        return $this->model->where('name', $name)->first();
    }

    public function toggleLike(User $user, Good $good): bool
    {
        $result = $user->likedGoods()->toggle($good->id);
        return count($result['attached']) > 0;
    }

    /**
     * @param User $user
     * @return Collection<int, Good>
     */
    public function getCartItems(User $user): Collection
    {
        return $user->goods()->withPivot('quantity')->get();
    }

    /**
     * @param User $user
     * @param int $productId
     * @return int
     */
    public function addToCart(User $user, int $productId): int
    {
        $existing = $user->goods()->where('product_id', $productId)->first();

        if ($existing) {
            /** @var Pivot&object{quantity: int} $pivot */
            $pivot = $existing->pivot;
            $newQuantity = $pivot->quantity + 1;
            $user->goods()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            $user->goods()->attach($productId, ['quantity' => 1]);
        }

        return $user->goods()->count();
    }

    /**
     * @param User $user
     * @param int $productId
     * @return bool
     */
    public function removeFromCart(User $user, int $productId): bool
    {
        $existing = $user->goods()->where('product_id', $productId)->first();

        if (!$existing) {
            return false;
        }

        /** @var Pivot&object{quantity: int} $pivot */
        $pivot = $existing->pivot;
        $newQuantity = $pivot->quantity - 1;

        if ($newQuantity > 0) {
            $user->goods()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            $user->goods()->detach($productId);
        }

        return true;
    }

    /**
     * @param User $user
     * @return void
     */
    public function clearCart(User $user): void
    {
        $user->goods()->detach();
    }
}
