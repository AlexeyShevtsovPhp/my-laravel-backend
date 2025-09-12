<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\GoodInspectResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Good\GoodRepository;

class GoodManage extends Controller
{
    /**
     * @param int $category_id
     * @return JsonResponse
     */

    public function __construct(protected GoodRepository $goodRepository)
    {
    }

    public function show(int $category_id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $liked = $this->goodRepository->getGoodsByCategoryWithLikes($category_id, $user);

        return response()->json($liked);
    }

    public function info(int $productId): GoodInspectResource
    {
        $info = $this->goodRepository->find($productId);

        return new GoodInspectResource($info);
    }
}
