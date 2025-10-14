<?php

declare(strict_types=1);

use App\Http\Middleware\Admin;
use App\Http\Middleware\CanViewUserCart;
use App\Http\Middleware\Cors;
use App\Http\Middleware\EnsureUserCanModifyComment;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Admin::class,
            'can.modify.comment' => EnsureUserCanModifyComment::class,
            'can.view.user.cart' => CanViewUserCart::class,
            'cors' => Cors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })
    ->withProviders([
        LaravelEasyRepository\LaravelEasyRepositoryServiceProvider::class,
    ])
    ->create();
