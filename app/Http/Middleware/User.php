<?php

//
//declare(strict_types=1);
//
//namespace App\Http\Middleware;
//
//use App\Models\Comment;
//use App\Models\User as UserModel;
//use Closure;
//use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Http\JsonResponse;
//
//class User
//{
//    /**
//     * @param Request $request
//     * @param Closure(Request): (Response) $next
//     * @return Response|JsonResponse
//     */
//
//    public function handle(Request $request, Closure $next): Response|JsonResponse
//    {
//        $commentId = $request->input('id');
//
//        $comment = Comment::find($commentId);
//
//        $user = auth()->user();
//
//        if ($comment === null) {
//            abort(404);
//        }
//
//        if ($user->role !== UserModel::ROLE_ADMIN && $user->id !== $comment->user_id) {
//            return response()->json(['', 403]);
//        }
//        return $next($request);
//    }
//}
