<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Str;

class OtpService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate an OTP (alphanumeric or numeric).
     *
     * @param int $length Length of the OTP.
     * @param bool $alphanumeric Whether the OTP should be alphanumeric.
     * @return string Generated OTP.
     */
    public function generateOtp($length = 6, $alphanumeric = true)
    {
        if ($alphanumeric) {
            return $this->generateAlphanumericOtp($length);
        }
        return $this->generateNumericOtp($length);
    }

    /**
     * Generate an alphanumeric OTP.
     *
     * @param int $length Length of the OTP.
     * @return string Alphanumeric OTP.
     */
    protected function generateAlphanumericOtp($length)
    {
        return Str::random($length);
    }

    /**
     * Generate a numeric OTP.
     *
     * @param int $length Length of the OTP.
     * @return string Numeric OTP.
     */
    protected function generateNumericOtp($length)
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return str_pad(random_int($min, $max), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Store a new OTP record.
     *
     * @param string $otp The OTP.
     * @param object $personalAccessToken Contains morph id and type.
     * @return Otp Created OTP record.
     */
    public function storeOtp($otp, array $otpable)
    {
        return Otp::create([
            'otp' => $otp,
            'otpable_id' => $otpable['otpable_id'],
            'otpable_type' => $otpable['otpable_type'],
            'expires_at' => now()->addMinutes(5)
        ]);
    }
}
