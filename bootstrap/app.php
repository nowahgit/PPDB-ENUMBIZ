<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware custom kita
        $middleware->alias([
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
            'guest.redirect' => \App\Http\Middleware\GuestMiddleware::class,
            'register_period' => \App\Http\Middleware\CheckRegistrationPeriod::class,
            'prevent-back' => \App\Http\Middleware\PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();