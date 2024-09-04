<?php

use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

// Customer Related Routes
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::group(['middleware' => ['auth:customer']], function () {
        Route::patch('/reset', [AuthController::class, 'reset_password']);
        Route::get('me', [AuthController::class, 'me']);
        Route::get('logout', [AuthController::class, 'logout']);

        Route::prefix('order')->group(function () {
            Route::post('/create-order', [OrderController::class, 'store']);
        });
    });
