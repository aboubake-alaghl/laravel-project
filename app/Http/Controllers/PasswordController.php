<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;

use App\Pipes\SendSmsConfirmationOtp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\RateLimiter;

class PasswordController extends Controller
{
    public function sendResetOtp(Request $request)
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

    public function sendResetLinkEmail(Request $request)
    {
        if (RateLimiter::tooManyAttempts('user-email' . $request->email, $perMinute = 10)) {
            return Response::tooManyRequests();
        }
        RateLimiter::increment('user-email' . $request->email, $decaySeconds = 86400);
        $response = Password::sendResetLink($request->only('email'));
        if ($response == Password::RESET_LINK_SENT) {
            RateLimiter::clear('user-email' . $request->email);
            return Response::ok(['Reset password link sent']);
        }
        return Response::error('Unable to send reset link');
    }

    public function resetPassword(ResetPassword $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) use ($request) {
                $user = $request->user();
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return Response::ok(['message' => 'Password changed successfully']);
        }
        return Response::error($status);
    }
}
