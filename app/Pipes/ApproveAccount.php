<?php

namespace App\Pipes;

use Closure;
use App\Models\Driver\Driver;

class ApproveAccount
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
        if (!$request->user()->hasVerifiedPhone()) {
            $request->user()->markPhoneAsVerified();
        }
        return $next($request);
    }
}
