<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Requests\RateProductRequest;
use App\Repositories\Rate\RateRepository;

#[AllowDynamicProperties]
class RatingGoodsController extends Controller
{
    public function __construct(public RateRepository $rateRepository)
    {
    }

    public function rate(RateProductRequest $rateProductRequest): Response
    {
        /** @var array{productId: int, userId: int, rating: int|float} $data */

        $data = $rateProductRequest->validated();
        $data['rating'] = (int)$data['rating'];

        $this->rateRepository->updateOrCreateRating($data);

        return response()->noContent();
    }
}
