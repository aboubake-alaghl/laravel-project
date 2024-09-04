<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceValueRequest;
use App\Http\Requests\Service\UpdateServiceValueRequest;
use App\Models\Service\Service;
use App\Models\Service\ServiceValue;

class ServiceValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Todo: Add pagniation
        return ServiceValue::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceValueRequest $request)
    {
        $validatedBody = $request->validated();
        // todo: may need to check type before inserting (for booleans for example).

        return ServiceValue::create([
            "value" => $validatedBody['value'],
            "service_attribute_id" => $validatedBody['service_attribute_id']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceValue $serviceValue)
    {
        return $serviceValue;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceValueRequest $request, int $id)
    {
        $validatedBody = $request->validated();
        return ServiceValue::where('id', $id)->update(['value' => $validatedBody['value']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceValue $serviceValue)
    {
        return $serviceValue->delete();
    }
}
