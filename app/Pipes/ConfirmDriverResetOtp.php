<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Models\Driver\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ConfirmDriverResetOtp
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
        try {
            $driver = Driver::findOrFail('phone', $request->phone);
            if ($driver) {
                $otp = DB::table('otps')
                    ->where('otpable_id', $driver->id)
                    ->where('otpable_type', Driver::class)
                    ->where('otp', $request->otp)
                    ->where('expires_at', '>', now())
                    ->where('is_used', false)
                    ->first();

                if ($otp) {
                    $otp->is_used = true;
                    return $next($request);
                }
            }
            return Response::unprocessable('invalid OTP');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
