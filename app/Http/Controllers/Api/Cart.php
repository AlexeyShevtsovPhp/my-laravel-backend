<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

class Cart extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @param AddCartItem $request
     * @return JsonResponse
     */
    public function add(AddCartItem $request): JsonResponse
    {
        $validated = $request->validated();
        /** @var ModelsUser $user */
        $user = Auth::user();
        $totalQuantity = $this->userRepository->addToCart($user, $validated['product_id']);

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

        $existing = $this->userRepository->removeFromCart($user, $productId);

        if (! $existing) {
            return response()->json(['message' => 'Товар не найден в корзине'], 404);
        }
        return response()->json(['message' => 'Товар обновлён или удалён']);
    }
    /**
     * @return JsonResponse
     */
    public function clear(): JsonResponse
    {
        /** @var ModelsUser $user */
        $user = Auth::user();
        $this->userRepository->clearCart($user);

        return response()->json(['message' => 'Корзина успешно очищена']);
    }
}
