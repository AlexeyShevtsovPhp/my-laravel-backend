<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Cart extends Controller
{
    /**
     * @param AddCartItem $request
     * @return JsonResponse
     */

    public function add(AddCartItem $request): JsonResponse
    {
        $validated = $request->validated();
        /** @var ModelsUser $user */
        $user = Auth::user();
        $productId = $validated['product_id'];

        $user->addToCart($productId);
        $user->load('goods');

        $totalQuantity = $user->goods()->count();

        event(new CartUpdated($user, $totalQuantity));

        return response()->json(['message' => 'Товар добавлен в корзину']);
    }

    /**
     * @param int $productId
     * @return JsonResponse
     */

    public function delete(int $productId): JsonResponse
    {
        /** @var ModelsUser $user */
        $user = Auth::user();

        $existing = $user->goods()->where('product_id', $productId)->first();

        if (! $existing) {
            return response()->json(['message' => 'Товар не найден в корзине'], 404);
        }

        /** @var Pivot&object{quantity: int} $pivot */
        $pivot = $existing->pivot;
        $newQuantity = $pivot->quantity - 1;

        $newQuantity > 0
            ? $user->goods()->updateExistingPivot($productId, ['quantity' => $newQuantity])
            : $user->goods()->detach($productId);

        return response()->json(['message' => 'Товар обновлён или удалён']);
    }

    /**
     * @return JsonResponse
     */

    public function clear(): JsonResponse
    {
        /** @var ModelsUser $user */

        $user = Auth::user();
        $user->goods()->detach();

        return response()->json(['message' => 'Корзина успешно очищена']);
    }
}
