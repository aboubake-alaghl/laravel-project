<?php

namespace App\Http\Controllers;

use Exception;
use App\Pipes\ConfirmOtp;
use App\Pipes\SendSmsConfirmationOtp;
use Illuminate\Http\Request;
use App\Pipes\ApproveAccount;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    /**
     * Send an OTP to the user's email or phone number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
        if (RateLimiter::tooManyAttempts('user-phone' . $request->phone, $perMinute = 5)) {
            return Response::tooManyRequests();
        }

        RateLimiter::increment('user-phone' . $request->phone, $decaySeconds = 900);

        try {
            Pipeline::send($request)
                ->through([
                    SendSmsConfirmationOtp::class,
                ])
                ->thenReturn();

            return Response::ok(['message' => 'Your OTP has been sent']);
        } catch (Exception $e) {

            return Response::exception($e);
        }
    }

    /**
     * Confirm OTP and approve user account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmOtp(Request $request)
    {
        try {
            Pipeline::send($request)
                ->through([
                    ConfirmOtp::class,
                    ApproveAccount::class
                ])
                ->thenReturn();

            return Response::ok(['message' => 'Account approved']);
        } catch (Exception $e) {

            return Response::error($e->getMessage());
        }
    }
}
