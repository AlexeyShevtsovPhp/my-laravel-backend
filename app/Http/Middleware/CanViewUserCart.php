<?php

namespace App\Http\Middleware;

use App\Enums\Role;
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
        /** @var User $userSelf */
        $userSelf = Auth::user();

        /** @var User $user */
        $user = $request->route('user');

        if ($userSelf->role !== Role::ADMIN->value && $userSelf->id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
