<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use App\Http\Resources\CategoryResource;

#[AllowDynamicProperties]
class CategoryManageController extends Controller
{
    public function __construct(public CategoryRepository $categoryRepository)
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryRepository->all());
    }
}
