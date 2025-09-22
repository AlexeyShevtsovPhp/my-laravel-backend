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
    protected ModelsUser $user;

    public function __construct(protected UserRepository $userRepository)
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user === null) {
                abort(401, 'Unauthorized');
            }
            $this->user = $user;
            return $next($request);
        });
    }

    /**
     * @param AddCartItem $request
     * @return Response
     */
    public function add(AddCartItem $request): Response
    {
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
        $this->userRepository->removeFromCart($this->user, $productId);
        return response()->noContent();
    }

    /**
     * @return Response
     */
    public function clear(): Response
    {
        $this->userRepository->clearCart($this->user);
        return response()->noContent();
    }
}
