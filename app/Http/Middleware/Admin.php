<?php

//
//declare(strict_types=1);
//
//namespace App\Http\Middleware;
//
//use Closure;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Http\JsonResponse;
//
//class Admin
//{
//    /**
//     * @param Request $request
//     * @param Closure(Request): (Response) $next
//     * @return Response|JsonResponse
//     */
//    public function handle(Request $request, Closure $next): Response|JsonResponse
//    {
//        $user = Auth::user();
//
//        if (!$user || $user->role !== 'admin') {
//            return response()->json('', 403);
//        }
//
//        return $next($request);
//    }
//}
