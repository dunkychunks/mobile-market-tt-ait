<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. This is the php Flasher setup
        $middleware->web(append: [
            \Flasher\Laravel\Middleware\SessionMiddleware::class,
            \Flasher\Laravel\Middleware\FlasherMiddleware::class,
        ]);

        // 2. This adds Zoraxy as a trusted proxy
        $middleware->trustProxies(at: '10.1.30.200');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
