<?php

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'jwt.verify' => \App\Http\Middleware\JWTMiddleware::class,
            'customer.auth' => \App\Http\Middleware\AuthenticateCustomer::class,
            'customer.guest' => \App\Http\Middleware\RedirectIfCustomer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        $exceptions->render(function (ValidationException $exception, $request) {
            if ($request->is('api/*') && $exception instanceof ValidationException) {
                return ApiResponse::error(
                    'Validation failed.',
                    422,
                    $exception->errors()
                );
            }
        });
    })->create();
