<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service\Service;
use App\Models\Service\ServiceAttribute;
use App\Models\Service\ServiceServiceAttribute;
use App\Models\Service\ServiceValue;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Todo: Add pagniation
        return Service::all();
    }

    public function toggleService(Service $service){
        $service->is_active = !$service->is_active;
        $service->save();
        return $service; 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $validatedBody = $request->validated();
        return DB::transaction(function () use ($validatedBody) {
            $service = Service::create([
                'name' => $validatedBody['name']
            ]);

            // Lopping on attributes, creating all sent service attibute for created $service
            foreach ($validatedBody['attributes'] as $key => $values) {
                $service_attribute = ServiceAttribute::create([
                    "label" => $key,
                    "type" => $values['type']
                ]);

                // Creating the givin service value for current lopping service attribute
                switch ($values['type']) {
                    case 'BOOL':
                        ServiceValue::create([
                            // value should be 1 or 0 Only
                            "value" => (bool)$values['value'][0],
                            "service_attribute_id" => $service_attribute->id
                        ]);
                        break;

                    case 'SINGLE':
                        ServiceValue::create([
                            "value" => $values['value'][0],
                            "service_attribute_id" => $service_attribute->id
                        ]);
                        break;

                    case 'CHECK':
                    case 'RADIO':
                        foreach ($values['value'] as $value) {
                            ServiceValue::create([
                                "value" => $value,
                                "service_attribute_id" => $service_attribute->id
                            ]);
                        }
                        break;

                    default:
                        throw response(['invalid type name'], 422);
                }

                // Creating the many to many relationship between the create service and current lopping service attribute.
                ServiceServiceAttribute::create([
                    "service_attribute_id" => $service_attribute->id,
                    "service_id" => $service->id,
                ]);
            }
            return $service;
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return $service;
    }

    // Update Service
    public function update(UpdateServiceRequest $request, int $id)
    {
        $validatedBody = $request->validated();
        return Service::where('id', $id)->update(['name' => $validatedBody['name']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // Todo: needs further analyzing, because services are related to orders, so there should be restrictions on deletion (prevening it or resulting to soft deletion)
        return DB::transaction(function() use ($id){
            ServiceServiceAttribute::where('service_id', $id)->delete();
            return Service::where('id', $id)->delete();
        });
    }
}
