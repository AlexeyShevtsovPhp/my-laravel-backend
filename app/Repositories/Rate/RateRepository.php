<?php

declare(strict_types=1);

namespace App\Repositories\Rate;

use LaravelEasyRepository\Repository;

interface RateRepository extends Repository
{
    /**
     * @param array{productId: int, userId: int, rating: int} $data
     */
    public function updateOrCreateRating(array $data): void;
}
