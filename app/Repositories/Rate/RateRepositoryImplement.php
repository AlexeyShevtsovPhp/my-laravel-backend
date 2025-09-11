<?php

namespace App\Repositories\Rate;

use App\Models\Rate;
use LaravelEasyRepository\Implementations\Eloquent;

class RateRepositoryImplement extends Eloquent implements RateRepository
{
    /**
     * @var Rate
     */
    protected $model;

    public function __construct(Rate $model)
    {
        $this->model = $model;
    }

    /**
     * @param array{productId: int, userId: int, rating: int|float} $data
     * @return Rate
     */

    public function updateOrCreateRating(array $data): Rate
    {
        return $this->model->updateOrCreate(
            [
                'product_id' => $data['productId'],
                'user_id' => $data['userId'],
            ],
            [
                'rating' => $data['rating'],
            ]
        );
    }
}
