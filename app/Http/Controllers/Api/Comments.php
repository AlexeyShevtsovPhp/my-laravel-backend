<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Comments extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $name = $user->name;
        $message = $request->input('comment');
        $categoryId = $request->input('category_id');
        $data = ['message' => $message];

        $validator = Validator::make($data, [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Необходимо заполнить все поля корректно',
                'errors' => $validator->errors(),
            ]);
        }

        $comment = Comment::query()->create([
            'user_id' => $user->id,
            'content' => $message,
            'category_id' => $categoryId,
        ]);
        $success = (bool)$comment;

        $response = [
            'name' => $name,
            'success' => $success,
            'message' => $success
                ? 'Ваш комментарий был успешно добавлен!'
                : 'Необходимо заполнить поле сообщения',
            'content' => $message,
        ];

        return response()->json($response);
    }

    public function delete(Request $request): JsonResponse
    {
        $commentId = $request->input('id');
        $comment = Comment::query()->find($commentId);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно удален.',
        ]);
    }

    public function show($userId): JsonResponse
    {
        $query = Comment::query()
            ->with('user');

        $query->where('user_id', $userId);
        $comments = $query->paginate(Comment::PER_PAGE);

        $response = [
            'comments' => $comments->transform(function ($comment) {
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

    public function read(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');

        $query = Comment::query()
            ->with('user');

        $request->has('category_id')
            ? $query->where('category_id', $request->input('category_id', 0))
            : $query->where('user_id', $userId);

        $comments = $query->paginate(Comment::PER_PAGE);

        $response = [
            'comments' => $comments->transform(function ($comment) {
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
