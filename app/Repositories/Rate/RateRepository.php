<?php

namespace App\Repositories\Rate;

use App\Models\Rate;
use LaravelEasyRepository\Repository;

interface RateRepository extends Repository
{
    /**
     * @param array{productId: int, userId: int, rating: int|float} $data
     * @return Rate
     */

    public function updateOrCreateRating(array $data): Rate;
}
