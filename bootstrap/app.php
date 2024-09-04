<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsurePhoneIsVerified;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1/customer')
                ->group(base_path('routes/api/v1/customer.php'));

            Route::middleware('api')
                ->prefix('api/v1/drivers')
                ->group(base_path('routes/api/v1/driver.php'));

            Route::middleware('api')
                ->prefix('api/v1/admin')
                ->group(base_path('routes/api/v1/admin.php'));

            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api/v1/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'email.verified' => EnsureEmailIsVerified::class,
            'phone.verified' => EnsurePhoneIsVerified::class
        ]);
        $middleware->api(prepend: [
            ForceJsonResponse::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
