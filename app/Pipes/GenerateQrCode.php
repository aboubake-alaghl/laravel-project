<?php

namespace App\Pipes;

use Closure;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate a QR code and add it to the request.
     *
     * @param object $request The incoming request.
     * @param Closure $next The next pipeline stage.
     * @return mixed Processed request.
     */
    public function handle($request, Closure $next)
    {
        $qrCodeSvg = QrCode::format('svg')
            ->size(200)
            ->generate(json_encode($request->data));

        $request->merge(['qr_code' => $qrCodeSvg]);

        $next($request);
    }
}
