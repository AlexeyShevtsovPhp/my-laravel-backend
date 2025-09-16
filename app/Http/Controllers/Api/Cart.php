<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\CartUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem;
use App\Models\User as ModelsUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;

class Cart extends Controller
{
    protected ?ModelsUser $user = null;

    public function __construct(protected UserRepository $userRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * @param AddCartItem $request
     * @return Response
     */
    public function add(AddCartItem $request): Response
    {
        if ($this->user === null) {
            abort(401);
        }

        $validated = $request->validated();
        $totalQuantity = $this->userRepository->addToCart($this->user, $validated['product_id']);

        event(new CartUpdated($this->user->id, $totalQuantity));

        return response()->noContent();
    }

    /**
     * @param int $productId
     * @return Response
     */
    public function delete(int $productId): Response
    {
        if ($this->user === null) {
            abort(401);
        }

        $existing = $this->userRepository->removeFromCart($this->user, $productId);

        if (!$existing) {
            abort(404);
        }
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function clear(): Response
    {
        if ($this->user === null) {
            abort(401);
        }

        $this->userRepository->clearCart($this->user);
        return response()->noContent();
    }
}
