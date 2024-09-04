<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Models\Order\Recipient;
use Illuminate\Support\Facades\DB;

class ConfirmOtp
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
        $otpable = $request->has('recipient_otp') ?
            Recipient::where('order_id', $request->id)->first() :
            $request->user();

        $otp = DB::table('otps')
            ->where('otpable_id', $otpable->id)
            ->where('otpable_type', get_class($otpable))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->where('is_used', false)
            ->first();

        if ($otp) {

            $otp->is_used = true;

            return $next($request);
        }

        throw new Exception('Ivalid Otp');
    }
}
