<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class User extends Controller
{
    public function index(): JsonResponse
    {
        $usersPerPage = ModelsUser::PER_PAGE;
        $users = ModelsUser::query()->paginate($usersPerPage);

        $meta = [
            'total' => $users->total(),
            'max_per_page' => $usersPerPage,
            'total_pages' => $users->lastPage(),
        ];
        $response = [
            'users' => $users->items(),
            'meta' => $meta,
        ];

        return response()->json($response);
    }
}
