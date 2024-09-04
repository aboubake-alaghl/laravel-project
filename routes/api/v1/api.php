<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\OtpController;

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(OtpController::class)->group(function () {
        Route::post('/confirm-otp',  'confirmOtp');
        Route::post('/send-otp', 'sendOtp');
    });
});

Route::post('/forgot-password', [PasswordController::class, 'sendResetLinkEmail']);
