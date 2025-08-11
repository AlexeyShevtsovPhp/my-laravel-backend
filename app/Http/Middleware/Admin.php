<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            if (str_contains($request->url(), 'monolit')) {
                return redirect('/monolit/categories/1?page=1');
            }

            return redirect('/categories/1?page=1&category_id=1');
        }

        return $next($request);
    }
}
