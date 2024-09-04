<?php

namespace App\Pipes;

use Closure;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

class NotifyDrivers
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle($request, Closure $next)
    {
        Notification::send($request->filteredDrivers, new OrderNotification($request->id));
    }
}
