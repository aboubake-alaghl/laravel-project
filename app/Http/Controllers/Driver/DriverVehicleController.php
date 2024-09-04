<?php

namespace App\Http\Controllers\Driver;

use Exception;
use Illuminate\Http\Request;
use App\Models\Vehicle\Vehicle;
use App\Services\VehicleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DriverVehicleController extends Controller
{
    public function addNewVehicle(Request $request)
    {
        $vehicleSerivce = new VehicleService();
        try {
            $vehicle = $vehicleSerivce->storeVehicle($request->user(), $request->all());
            return Response::created($vehicle);
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }

    public function setDefaultVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return Response::unprocessable($validator->errors());
        }

        $request->user()->vehicle_id = $request->vehicle_id;

        $request->user()->save();

        return Response::ok('Default vehicle was successfully updated.');
    }
}
