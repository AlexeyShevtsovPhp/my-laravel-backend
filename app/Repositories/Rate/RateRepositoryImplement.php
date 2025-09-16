<?php

namespace App\Repositories\Rate;

use App\Models\Rate;
use LaravelEasyRepository\Implementations\Eloquent;

class RateRepositoryImplement extends Eloquent implements RateRepository
{
    /**
     * @return void
     */
    public function __construct(protected Rate $model)
    {
    }

    /**
     * @param array{productId: int, userId: int, rating: int} $data
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
