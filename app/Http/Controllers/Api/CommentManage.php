<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\ChatDelete;
use App\Events\ChatUpdated;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Resources\CommentCollectionResource;
use App\Http\Resources\CommentCreateResource;
use App\Models\Comment;
use App\Models\User as ModelsUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Comment\CommentRepository;

class CommentManage extends Controller
{
    protected ModelsUser $user;

    public function __construct(protected CommentRepository $commentRepository)
    {
        $this->middleware('auth:sanctum');

        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user === null) {
                abort(401, 'Unauthorized');
            }
            $this->user = $user;
            return $next($request);
        });
    }

    /**
     * @param CreateCommentRequest $createCommentRequest
     * @return JsonResponse
     */
    public function create(CreateCommentRequest $createCommentRequest): JsonResponse
    {
        $data = $createCommentRequest->validated();

        $data['user_id'] = $this->user->id;

        $comment = $this->commentRepository->createComment($data);

        event(new ChatUpdated($this->user, $comment));

        return response()->json(new CommentCreateResource($comment), 201);
    }

    /**
     * @param Comment $comment
     * @return Response
     */
    public function delete(Comment $comment): Response
    {
        event(new ChatDelete($comment));

        $this->commentRepository->deleteComment($comment);

        return response()->noContent();
    }

    /**
     * @param Request $request
     * @return CommentCollectionResource
     */
    public function read(Request $request): CommentCollectionResource
    {
        $comments = $this->commentRepository->getPaginatedComments($request);

        return new CommentCollectionResource($comments);
    }
}
