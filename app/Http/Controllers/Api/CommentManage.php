<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\ChatDelete;
use App\Events\ChatUpdated;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Resources\CommentCollectionResource;
use App\Http\Resources\CommentCreateResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Comment\CommentRepository;

class CommentManage extends Controller
{
    protected CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param CreateCommentRequest $request
     * @return JsonResponse
     */

    public function create(CreateCommentRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $comment = $this->commentRepository->createComment([
            'user_id' => $user->id,
            'content' => $request->input('comment'),
            'category_id' => $request->input('category_id'),
        ]);

        event(new ChatUpdated($user, $comment));

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно добавлен',
            'comment' => new CommentCreateResource($comment),
        ], 201);
    }
    /**
     * @param Comment $comment
     * @return JsonResponse
     */

    public function delete(Comment $comment): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role !== 'admin' && $comment->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Нет прав на удаление этого комментария',
            ], 403);
        }

        event(new ChatDelete($comment));

        $this->commentRepository->deleteComment($comment);

        return response()->json([
            'success' => true,
            'message' => 'Комментарий успешно удалён',
        ]);
    }

    /**
     * @param Request $request
     * @return CommentCollectionResource
     */

    public function read(Request $request): CommentCollectionResource
    {
        $comments = $this->commentRepository->getPaginatedComments($request, 5);

        return new CommentCollectionResource($comments);
    }
}
