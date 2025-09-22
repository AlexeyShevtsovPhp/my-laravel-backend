<?php

namespace App\Http\Middleware;

use App\Enums\Status;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanViewUserCart
{
    /**
     * @param Request $request
     * @param Closure(Request): Response $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $userSelf */
        $userSelf = Auth::user();

        /** @var User|null $user */
        $user = $request->route('user');

        if (!$userSelf || !$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($userSelf->role !== Status::ADMIN->value && $userSelf->id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
