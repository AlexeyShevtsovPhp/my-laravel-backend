<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Requests\RateProduct;
use App\Repositories\Rate\RateRepository;

#[AllowDynamicProperties]
class RatingGoods extends Controller
{
    protected RateRepository $rateRepository;

    public function __construct(RateRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function rate(RateProduct $request): JsonResponse
    {
        /** @var array{productId: int, userId: int, rating: int|float} $data */

        $data = $request->validated();

        $this->rateRepository->updateOrCreateRating($data);

        return response()->json(['success' => true]);
    }
}
