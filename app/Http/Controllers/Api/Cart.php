<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use App\Http\Resources\UserGoodResource;
use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Cart extends Controller
{
    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */

    public function all(ModelsUser $user): JsonResponse
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }

        $user->load('goods');

        $goods = $user->goods()->get();
        $items = UserGoodResource::collection($goods);

        $totalSum = $user->getTotalGoodsSum();

        return response()->json([
            'items' => $items,
            'totalSum' => $totalSum,
            'totalItems' => $goods->count(),
        ]);
    }
    /**
     * @param ModelsUser $user
     * @return JsonResponse
     */

    public function show(ModelsUser $user): JsonResponse
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }

        $goods = $user->goods()->paginate(5);
        $items = UserGoodResource::collection($goods);

        $user->load('goods');
        $totalSum = $user->getTotalGoodsSum();

        return response()->json([
            'items' => $items,
            'totalSum' => $totalSum,
            'currentPage' => $goods->currentPage(),
            'lastPage' => $goods->lastPage(),
            'totalItems' => $goods->total(),
        ]);
    }

    /**
     * @param AddCartItem $request
     * @return JsonResponse
     */

    public function create(AddCartItem $request): JsonResponse
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
        $currentQuantity = $pivot->quantity;

        if ($currentQuantity > 1) {
            $user->goods()->updateExistingPivot($productId, [
                'quantity' => $currentQuantity - 1,
            ]);
        } else {
            $user->goods()->detach($productId);
        }

        return response()->json(['message' => 'Товар обновлён или удалён']);
    }

    /**
     * @return JsonResponse
     */

    public function clearAll(): JsonResponse
    {
        /** @var ModelsUser $user */

        $user = Auth::user();
        $user->goods()->detach();

        return response()->json(['message' => 'Корзина успешно очищена']);
    }
}
