<?php

namespace App\Pipes;

use Closure;
use Exception;

use App\Jobs\SendOtpMailJob;
use App\Services\OtpService;
use App\Models\Driver\Driver;
use Illuminate\Support\Facades\DB;

class SendEmailConfirmationOtp
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Stores new driver and generates an API token.
     *
     * @param  mixed $request
     * @param  Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $personalAccessToken = DB::table('personal_access_tokens')
            ->where('tokenable_type', Driver::class)
            ->where('tokenable_id', $request->id)
            ->first();

        $otpService = new OtpService();

        try {
            $otp = $otpService->generateOtp();
            $otpService->storeOtp($otp, $personalAccessToken);
            dispatch(new SendOtpMailJob($request->email, $otp))->afterResponse();
            return $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
