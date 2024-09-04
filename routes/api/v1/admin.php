<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Service\ServiceAttributeController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\ServiceValueController;
use Illuminate\Support\Facades\Route;

Route::post('/signin', [AuthController::class, 'signin']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::group(['middleware' => ['auth']], function () {
    Route::prefix('service')->group(function () {
        Route::post('', [ServiceController::class, 'store']);
        Route::get('', [ServiceController::class, 'index']);
        Route::patch('/{id}', [ServiceController::class, 'update']);
        Route::get('/{service}', [ServiceController::class, 'show']);
        Route::delete('/{id}', [ServiceController::class, 'destroy']);
        Route::get('/toggle-service/{service}', [ServiceController::class, 'toggleService']);
    });

    Route::prefix('service-attribute')->group(function () {
        Route::post('', [ServiceAttributeController::class, 'store']);
        Route::get('', [ServiceAttributeController::class, 'index']);
        Route::patch('/{id}', [ServiceAttributeController::class, 'update']);
        Route::get('/{serviceAttribute}', [ServiceAttributeController::class, 'show']);
        Route::delete('/{id}', [ServiceAttributeController::class, 'destroy']);
    });

    Route::prefix('service-value')->group(function () {
        Route::post('', [ServiceValueController::class, 'store']);
        Route::get('', [ServiceValueController::class, 'index']);
        Route::patch('/{id}', [ServiceValueController::class, 'update']);
        Route::get('/{ServiceValue}', [ServiceValueController::class, 'show']);
        Route::delete('/{ServiceValue}', [ServiceValueController::class, 'destroy']);
    });
});
