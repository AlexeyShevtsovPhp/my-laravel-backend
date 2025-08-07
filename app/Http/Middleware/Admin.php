<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {

            if (str_contains($request->url(), 'monolit')) {
                return redirect('/monolit/categories/1?page=1');
            }
            return redirect('/categories/1?page=1&category_id=1');
        }

        return $next($request);
    }
}
