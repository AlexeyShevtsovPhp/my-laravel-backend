<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Category as CategoryModel;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

#[AllowDynamicProperties]
class Category extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = CategoryModel::query()
            ->paginate(CategoryModel::PER_PAGE);

        return response()->json($categories);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function read(Request $request): JsonResponse
    {
        $comments = Comment::query()
            ->where('category_id', $request->input('category_id'))
            ->with('user')
            ->paginate(Comment::PER_PAGE);

        $response = [
            'comments' => $comments->transform(function (Comment $comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'username' => $comment->user ? $comment->user->name : 'Guest',
                ];
            }),
            'meta' => [
                'total_pages' => $comments->lastPage(),
                'current_page' => $comments->currentPage(),
            ]
        ];
        return response()->json($response);
    }
}

