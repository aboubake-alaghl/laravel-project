<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Driver\AuthController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\Driver\DeliveryController;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Http\Controllers\Driver\DriverVehicleController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup',  'signup');
    Route::post('/login', 'login');
    Route::middleware(['auth:driver'])->group(function () {
        Route::post('/logout', 'logout');
        Route::post('/reset-password', 'resetPassword');
    });
});

Route::middleware(['auth:driver', 'phone.verified'])->group(function () {
    Route::controller(DriverVehicleController::class)->group(function () {
        Route::post('/vehicles/add-vehicle', 'addNewVehicle');
        Route::post('/vehicles/default-vehicle', 'setDefaultVehicle');
    });
    Route::controller(DeliveryController::class)->group(function () {
        Route::post('/update-delivery-status', 'updateDeliveryStatus');
        Route::post('/pickup-order', 'pickupOrder');
        Route::post('/confirm-order', 'confirmOrder');
    });
});
