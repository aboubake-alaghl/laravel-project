<?php

namespace App\Pipes\Order;

use App\Services\DriverService;
use Closure;
use Exception;

class FilterDriversPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the process of creating a new order.
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
            $filteredDrivers = $driverService->filterDrivers($request->order['service_id']);

            $request->merge([
                'filteredDrivers' => $filteredDrivers,
            ]);

            return $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
