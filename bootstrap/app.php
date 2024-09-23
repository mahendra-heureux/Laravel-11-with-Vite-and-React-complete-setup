<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
           
        ]);
        $middleware->alias([
           'log.request.response' => \App\Http\Middleware\LogRequestResponse::class,
           'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        // $middleware->appendToGroup('api', [
        //     'throttle:api',
        //     \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //     \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // Add this line
        // ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            \Log::info('Login attempt', $request->all());

            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 401);
            }
        });
    })->create();
