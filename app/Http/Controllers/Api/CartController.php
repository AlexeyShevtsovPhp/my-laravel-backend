<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItemRequest;
use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(public UserRepository $userRepository)
    {
    }

    /**
     * @param AddCartItemRequest $addCartItemRequest
     * @return Response
     */
    public function add(AddCartItemRequest $addCartItemRequest): Response
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $addCartItemRequest->validated();
        $totalQuantity = $this->userRepository->addToCart($user, $validated['product_id']);

        CartUpdated::dispatch((int)Auth::id(), $totalQuantity);

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
