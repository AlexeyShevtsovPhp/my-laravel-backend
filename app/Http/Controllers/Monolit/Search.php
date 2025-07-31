<?php

namespace App\Http\Controllers\Monolit;

use AllowDynamicProperties;
use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class Search extends Controller
{
    /**
     * Поиск категорий с учётом запроса
     *
     * @param Request $request
     * @return object
     */
    public function index(Request $request): object
    {
        $search = $request->query('search');

        $find = CategoryModel::when($search, fn($query) => $query->where('name', 'like', "%$search%"))
            ->get();

        return response()->json(['data' => $find]);
    }

}

