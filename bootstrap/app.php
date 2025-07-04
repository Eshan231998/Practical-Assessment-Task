<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add global middleware here
        // $middleware->append(EnsureTokenIsValid::class);
        // To add IsAdmin globally (not recommended for all routes):
        // $middleware->append(IsAdmin::class);
        // Usually, you want to use route middleware for IsAdmin, not global.
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
