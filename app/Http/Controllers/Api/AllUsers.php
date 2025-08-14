<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFullInfoResource;
use App\Models\Comment;
use App\Models\Good;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;

class AllUsers extends Controller
{
    /**
     * @param ModelsUser $user
     * @return UserFullInfoResource
     */

    public function info(ModelsUser $user): UserFullInfoResource
    {
        /** @var ModelsUser $userSelf */

        $userSelf = Auth::user();

        if ($userSelf->role !== 'admin' && $user->id !== $userSelf->id) {
            abort(403, 'Доступ запрещён');
        }

        $liked = $user->likedGoods()->pluck('goods.id');

        $comments = Comment::query()->with('user')->where('user_id', $user->id)->paginate(5);

        $goods = $user->goods()->paginate(5);

        $allGoods = Good::all();

        $totalSum = $user->getTotalGoodsSum();

        $user->setRelation('comments', $comments);
        $user->setRelation('goods', $goods);

        $user->liked = $liked;
        $user->totalSum = $totalSum;
        $user->allGoods = $allGoods;

        return new UserFullInfoResource($user);
    }
}
