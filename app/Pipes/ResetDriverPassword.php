<?php

namespace App\Pipes;

use Closure;
use Exception;
use App\Services\DriverService;

class ResetDriverPassword
{
    protected $driverService;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->driverService = new DriverService();
    }

    public function handle($request, Closure $next)
    {
        try {
            $driver = $request->user()->id;
            $this->driverService->updatePassword($driver, $request->password);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
