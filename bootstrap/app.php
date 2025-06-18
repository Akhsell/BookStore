<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Mendaftarkan alias middleware 'admin' dan 'user'
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'user' => UserMiddleware::class,
        ]);

        // Jika ingin menambahkan middleware global, bisa menggunakan:
        // $middleware->prepend(SomeGlobalMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
