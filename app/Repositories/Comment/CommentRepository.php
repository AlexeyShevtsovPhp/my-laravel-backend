<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use LaravelEasyRepository\Repository;

interface CommentRepository extends Repository
{
    /**
     * @param array{user_id: int, content: string, category_id: int} $data
     * @return Comment
     */

    public function createComment(array $data): Comment;
    public function deleteComment(Comment $comment): bool;

    /**
     * @return LengthAwarePaginator<int, Comment>
     */

    public function getPaginatedComments(Request $request, int $perPage = 5): LengthAwarePaginator;
}
