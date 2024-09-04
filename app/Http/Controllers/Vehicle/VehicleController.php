<?php

namespace App\Http\Controllers\Vehicle;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\StoreRequest;
use App\Services\VehicleService;
use Illuminate\Support\Facades\Response;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $vehicleSerivce = new VehicleService();
        try {
            $vehicleSerivce->storeVehicle($request->user(), $request->all());
            return Response::created();
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
