<?php

namespace App\Http\Controllers\Monolit;

use AllowDynamicProperties;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

#[AllowDynamicProperties]
class Cart extends Controller
{
    public function show(ModelsUser $user): object
    {
        /** @var ModelsUser $userSelf */
        $userSelf = Auth::user();
        $goods = $user->goods()->paginate(5);

        $path = match ($user->role) {
            User::ROLE_ADMIN => "/images/userIcon/admin.png",
            'guest' => "/images/userIcon/guest.png",
            default => '',
        };

        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            return redirect('/categories');
        }

        switch ($user->role) {
            case 'admin':
                $button = 'active';
                break;
            case 'guest':
                $button = 'not-active';
                break;
            default:
        }
        if ($goods->currentPage() > $goods->lastPage()) {
            return redirect('/monolit/cart/' . $user->id . '?page=' . $goods->lastPage());
        }

        $allGoods = $user->goods()->get();

        $totalSum = $allGoods->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->pivot->quantity;
        });

        return view('/monolit/cart', [
            'name' => $user->name,
            'user' => $user,
            'goods' => $goods,
            'totalPages' => $goods->lastPage(),
            'currentPage' => $goods->currentPage(),
            'path' => $path,
            'button' => $button,
            'totalSum' => $totalSum,
        ]);
    }

    public function create(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $productId = $request->input('product_id');

        $goodsList = $user->goods()->wherePivot('product_id', $productId)->first();

        if ($goodsList) {
            $currentQuantity = $goodsList->pivot->quantity;
            $user->goods()->updateExistingPivot($productId, [
                'quantity' => $currentQuantity + 1
            ]);
        } else {
            $user->goods()->attach($productId, ['quantity' => 1]);
        }
        return response()->json(['message' => 'Товар был успешно добавлен в корзину']);
    }

    public function delete(Request $request)
    {
        $user = auth()->user();
        $productId = $request->input('product_id');

        $pivot = $user->goods()->where('product_id', $productId)->first();

        $currentQuantity = $pivot->pivot->quantity;

        if ($currentQuantity > 1) {
            $user->goods()->updateExistingPivot($productId, [
                'quantity' => $currentQuantity - 1
            ]);
        } else {
            $user->goods()->detach($productId);
        }

        return response()->json(['message' => 'Товар обновлён или удалён']);
    }
}
