<?php

use Illuminate\Http\Request;
use App\Models\Driver\Driver;
use Illuminate\Support\Facades\Route;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/notifications', function (Request $request) {
    Notification::send(Driver::find(1), new OrderNotification(1));
});
