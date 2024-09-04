<?php

namespace App\Http\Controllers\Driver;

use Exception;
use App\Pipes\ConfirmOtp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Driver\Driver;
use App\Pipes\CreateDriverAccount;
use App\Pipes\ResetDriverPassword;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Hash;
use App\Pipes\SendSmsConfirmationOtp;
use App\Pipes\SendWelcomeNotification;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Driver\StoreRequest;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Handle the driver signup process.
     * Generate a QR code, create a driver account,
     * and send an email confirmation OTP.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(StoreRequest $request)
    {
        try {
            Pipeline::send($request)
                ->through([
                    CreateDriverAccount::class,
                    SendSmsConfirmationOtp::class,
                    SendWelcomeNotification::class
                ])
                ->thenReturn();

            return Response::created([
                'driver' => $request->driver,
                'token' => $request->token
            ]);
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Handle the driver login process.
     * Uses rate limiting to prevent too many login attempts.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (RateLimiter::tooManyAttempts('driver-identifier' . $request->identifier, $perMinute = 10)) {
            return Response::tooManyRequests();
        }

        RateLimiter::increment('driver-identifier' . $request->identifier, $decaySeconds = 86400);

        $driver = Driver::where('is_active', true)
            ->where(function ($query) use ($request) {
                $query->where('phone', $request->identifier)
                    ->orWhere('email', $request->identifier);
            })
            ->first();

        if ($driver && Hash::check($request->password, $driver->password)) {

            $driver->setRememberToken(Str::random(60));

            RateLimiter::clear('driver-phone' . $request->phone);

            if (!$driver->hasVerifiedPhone()) {
                return Response::error([
                    'message' => 'Please verify your phone'
                ]);
            }

            return Response::ok(
                [
                    'data' => $driver,
                    'token' => $driver->createToken($driver->phone . '' . $driver->id)->plainTextToken,
                ]
            );
        }
        return Response::unauthorised();
    }

    /**
     * Revoke driver's token and log out.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $request
                ->user()
                ->currentAccessToken()
                ->delete();
            return Response::ok([
                'message' => 'Logged out successfully.'
            ]);
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }
    /**
     * Resets Driver password with OTP.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPassword $request)
    {
        try {
            Pipeline::send($request)
                ->through([
                    SendSmsConfirmationOtp::class,
                    ConfirmOtp::class,
                    ResetDriverPassword::class,
                ])
                ->thenReturn();
            return Response::updated('Password updated successfully');
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }
}
