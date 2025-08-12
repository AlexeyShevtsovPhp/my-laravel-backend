<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Category as CategoryModel;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use App\Http\Resources\CategoryResource;

#[AllowDynamicProperties]
class CategoryManage extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */

    public function index()
    {
        $categories = CategoryModel::query()->get();

        return CategoryResource::collection($categories);
    }
}
