<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Category;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{
    /**
     * @property Category $model;
     */

    public function __construct(protected Category $model)
    {
    }
}
