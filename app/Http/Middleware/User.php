<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use App\Models\User as UserModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $commentId = $request->input('id');
        $comment = Comment::query()->find($commentId);

        /** @var UserModel $user */
        $user = auth()->user();

        if ($user->role !== UserModel::ROLE_ADMIN && $user->id !== $comment->user_id) {
            return redirect('/categories/category?page=0' . $comment->page . '&category_id=' . $comment->category_id);
        }

        return $next($request);
    }
}
