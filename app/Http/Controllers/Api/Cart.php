<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use App\Models\User;
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
        /** @var User $user */
        $user = Auth::user();
        $totalQuantity = $this->userRepository->addToCart($user, $validated['product_id']);

        event(new CartUpdated($user->id, $totalQuantity));

        return response()->noContent();
    }

    /**
     * @param int $productId
     * @return Response
     */
    public function delete(int $productId): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $this->userRepository->removeFromCart($user, $productId);
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function clear(): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $this->userRepository->clearCart($user);
        return response()->noContent();
    }
}
