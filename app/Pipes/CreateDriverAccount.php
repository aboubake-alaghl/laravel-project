<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Services\DriverService;

class CreateDriverAccount
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the process of creating a new driver account.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $driverService = new DriverService();
        try {
            $driver = $driverService->storeDriver($request->validated());
            $token = $driver->createToken($driver->identifier . '' . $driver->id)->plainTextToken;

            $request->merge([
                'id' => $driver->id,
                'user_type' => get_class($driver),
                'token' => $token,
                'driver' => collect($driver)
            ]);

            return $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
