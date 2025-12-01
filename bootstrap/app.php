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
        // Configure the web middleware group to enable sessions, cookies, CSRF, and bindings.
        $middleware->web(append: [
            Illuminate\Cookie\Middleware\EncryptCookies::class,
            Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            Illuminate\Session\Middleware\StartSession::class,
            Illuminate\View\Middleware\ShareErrorsFromSession::class,
            Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Register common route middleware aliases used by routes like 'auth' and 'verified'.
        $middleware->alias([
            'auth' => Illuminate\Auth\Middleware\Authenticate::class,
            'verified' => Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'signed' => Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => Illuminate\Routing\Middleware\ThrottleRequests::class,
            'password.confirm' => Illuminate\Auth\Middleware\RequirePassword::class,
        ]);
    })
    ->withExceptions(function (): void {
        //
    })->create();
