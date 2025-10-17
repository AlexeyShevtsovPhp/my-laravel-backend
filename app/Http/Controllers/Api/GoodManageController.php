<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\GoodInspectResource;
use App\Http\Resources\GoodWithLikesResource;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Good\GoodRepository;

class GoodManageController extends Controller
{
    public function __construct(public GoodRepository $goodRepository)
    {
    }

    /**
     * @param int $category_id
     * @return GoodWithLikesResource
     */
    public function show(int $category_id): GoodWithLikesResource
    {
        /** @var User $user */
        $user = Auth::user();
        return new GoodWithLikesResource($this->goodRepository->getGoodsByCategoryWithLikes($category_id, $user));
    }

    public function info(int $productId): GoodInspectResource
    {
        return new GoodInspectResource($this->goodRepository->find($productId));
    }
}
