<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use Illuminate\Http\Response;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class Cart extends Controller
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    /**
     * @param AddCartItem $request
     * @return Response
     */
    public function add(AddCartItem $request): Response
    {
        $validated = $request->validated();
        $totalQuantity = $this->userRepository->addToCart($validated['product_id']);

        event(new CartUpdated((int)Auth::id(), $totalQuantity));

        return response()->noContent();
    }

    /**
     * @param int $productId
     * @return Response
     */
    public function delete(int $productId): Response
    {
        $this->userRepository->removeFromCart($productId);
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function clear(): Response
    {
        $this->userRepository->clearCart();
        return response()->noContent();
    }
}
