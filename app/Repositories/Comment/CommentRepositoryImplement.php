<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use LaravelEasyRepository\Implementations\Eloquent;

class CommentRepositoryImplement extends Eloquent implements CommentRepository
{
    protected Comment $model;

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * @param array{user_id: int, content: string, category_id: int} $data
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
     * @return LengthAwarePaginator<int, Comment>
     */
    public function getPaginatedComments(Request $request, int $perPage = 5): LengthAwarePaginator
    {
        $query = $this->model->buildCommentQuery($request);

        return $query->paginate($perPage);
    }
}
