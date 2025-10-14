<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\ChatDelete;
use App\Events\ChatUpdated;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Resources\CommentCollectionResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Repositories\Comment\CommentRepository;

class CommentManageController extends Controller
{
    protected User $user;

    public function __construct(protected CommentRepository $commentRepository)
    {
    }

    /**
     * @param CreateCommentRequest $createCommentRequest
     * @return Response
     */
    public function create(CreateCommentRequest $createCommentRequest): Response
    {
        /** @var User $user */
        $user = $createCommentRequest->user();

        $comment = $this->commentRepository->
        createComment(array_merge($createCommentRequest->validated(), ['user_id' => $user->id]));

        event(new ChatUpdated($user, $comment));

        return response()->noContent();
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
        return new CommentCollectionResource($this->commentRepository->
        getPaginatedComments($request, $request->input('perPage', 5)));
    }
}
