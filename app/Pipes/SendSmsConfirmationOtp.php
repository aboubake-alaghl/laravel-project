<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Jobs\SendOtpSmsJob;
use App\Services\OtpService;
use Illuminate\Support\Facades\DB;

class SendSmsConfirmationOtp
{
    protected $otpService;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->otpService = new OtpService();
    }

    public function handle($request, Closure $next)
    {
        try {
            $otp = $this->otpService->generateOtp();
            if ($request->user() === null) {

                $personalAccessToken = DB::table('personal_access_tokens')
                    ->where('tokenable_type', $request->user_type)
                    ->where('tokenable_id', $request->id)
                    ->first();

                $otpable_id = $personalAccessToken->tokenable_id;
                $otpable_type = $personalAccessToken->tokenable_type;
            } else {
                $otpable_id = $request->user()->id;
                $otpable_type = get_class($request->user());
            }
            SendOtpSmsJob::dispatchAfterResponse(
                $request->driver['phone'],
                $otp,
                fn() => $this->otpService->storeOtp($otp, [
                    'otpable_id' => $otpable_id,
                    'otpable_type' => $otpable_type
                ])
            );
            $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
