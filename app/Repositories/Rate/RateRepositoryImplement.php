<?php

declare(strict_types=1);

namespace App\Repositories\Rate;

use App\Models\Rate;
use LaravelEasyRepository\Implementations\Eloquent;

class RateRepositoryImplement extends Eloquent implements RateRepository
{
    /**
     * @return void
     */
    public function __construct(public Rate $model)
    {
    }

    /**
     * @param array{productId: int, userId: int, rating: int} $data
     * @return Void
     */
    public function updateOrCreateRating(array $data): void
    {
        $this->model->updateOrCreate(
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
