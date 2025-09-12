<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class CommentRepositoryImplement extends Eloquent implements CommentRepository
{

    public function __construct(protected Comment $model)
    {
    }
    /**
     * @param array{post_id: int, user_id: int, content: string} $data
     * @return Comment
     */
    public function createComment(array $data): Comment
    {
        return $this->model->create($data);
    }
    public function deleteComment(Comment $comment): bool
    {
        return (bool) $comment->delete();
    }
    /**
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator<int, Comment>
     */
    public function getPaginatedComments(Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model->buildCommentQuery($request);

        return $query->paginate($perPage);
    }
}
