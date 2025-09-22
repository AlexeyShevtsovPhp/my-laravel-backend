<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\Comment;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserCanModifyComment
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();
        /** @var Comment|null $comment */
        $comment = $request->route('comment');

        if (!$comment) {
            return response('Comment not found', 404);
        }

        if (!$user) {
            return response('Unauthorized', 401);
        }

        if ($user->role !== Status::ADMIN->value && $comment->user_id !== $user->id) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
