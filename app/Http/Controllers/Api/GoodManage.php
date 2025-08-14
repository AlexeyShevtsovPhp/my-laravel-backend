<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Good;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GoodManage extends Controller
{
    /**
     * @param int $category_id
     * @return JsonResponse
     */

    public function show(int $category_id): JsonResponse
    {
        /** @var User $user */

        $user = Auth::user();
        $liked = Good::favoriteGoods($category_id, $user);

        return response()->json($liked);
    }
}
