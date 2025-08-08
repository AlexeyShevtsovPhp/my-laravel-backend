<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\ChatDelete;
use App\Events\ChatUpdated;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentManage extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Требуется аутентификация',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Необходимо заполнить все поля корректно',
                'errors' => $validator->errors(),
            ], 422);
        }

        $comment = Comment::create([
            'user_id' => $user->id,
            'content' => $request->input('comment'),
            'category_id' => $request->input('category_id'),
        ]);

        event(new ChatUpdated($user, $comment));

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно добавлен',
            'comment' => $comment,
        ], 201);
    }

    /**
     * @param Comment $comment
     * @return JsonResponse
     */

    public function delete(Comment $comment): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Требуется аутентификация',
            ], 401);
        }

        if ($user->role !== 'admin' && $comment->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав на удаление этого комментария',
            ], 403);
        }

        event(new ChatDelete($comment));

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно удалён',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function read(Request $request): JsonResponse
    {
        $query = Comment::query()->with('user');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        $comments = $query->paginate(5);

        $response = [
            'comments' => $comments->getCollection()->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'username' => $comment->user->name,
                    'category_id' => $comment->category_id,
                    'created_at' => $comment->created_at?->toDateTimeString() ?? 'N/A',
                ];
            }),
            'meta' => [
                'total_pages' => $comments->lastPage(),
                'current_page' => $comments->currentPage(),
                'total' => $comments->total(),
            ],
        ];

        return response()->json($response);
    }
}
