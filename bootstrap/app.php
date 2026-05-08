<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RestrictByIPRange;
use App\Http\Middleware\ObfuscatedRouteMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
          // Register the IP range middleware here
          $middleware->alias([
            'restrict.ip' => RestrictByIPRange::class
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Register your middleware here
        $middleware->append(ObfuscatedRouteMiddleware::class);
    })
 
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
