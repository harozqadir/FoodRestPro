<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isCasher;
use App\Http\Middleware\isChef;
use App\Http\Middleware\isServer;
use App\Http\Middleware\SetLocale;
\App\Http\Middleware\SetLocale::class;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registering middleware aliases
        $middleware->alias([
            'isAdmin' => isAdmin::class,
            'isServer' => isServer::class,
            'isCasher' => isCasher::class,
            'isChef' => isChef::class,
            'setLocale' => SetLocale::class, // <-- Add this line

        ]);
                $middleware->append(SetLocale::class); // <-- Add this line to run for all web requests

        
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    