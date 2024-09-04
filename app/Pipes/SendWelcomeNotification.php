<?php

namespace App\Pipes;

use App\Jobs\WelcomNotificationJob;
use Closure;

class SendWelcomeNotification
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
        WelcomNotificationJob::dispatchAfterResponse($request->id, $request->user_type);
        $next($request);
    }
}
