<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Vehicle\Vehicle;
use Exception;

class VehicleService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function storeVehicle($driver, $data)
    {
        try {
            $vehicle = $driver->vehicle()->create($data);
            $driver->vehicle_id = $vehicle->id;
            $driver->save();
            return $vehicle;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
