<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceAttributeRequest;
use App\Http\Requests\Service\UpdateServiceAttributeRequest;
use App\Models\Service\ServiceAttribute;
use App\Models\Service\ServiceServiceAttribute;
use App\Models\Service\ServiceValue;
use Illuminate\Support\Facades\DB;

class ServiceAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Todo: Add pagniation
        return ServiceAttribute::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceAttributeRequest $request)
    {
        $validatedBody = $request->validated();
        return DB::transaction(function () use ($validatedBody) {
            $service_attribute = ServiceAttribute::create([
                "label" => $validatedBody['attribute_label'],
                "type" => $validatedBody['attribute_type'],
            ]);
            // Creating the givin service value for current lopping service attribute
            switch ($validatedBody['attribute_type']) {
                case 'BOOL':
                    ServiceValue::create([
                        // value should be 1 or 0 Only
                        "value" => (bool)$validatedBody['value'][0],
                        "service_attribute_id" => $service_attribute->id
                    ]);
                    break;

                case 'SINGLE':
                    ServiceValue::create([
                        "value" => $validatedBody['value'][0],
                        "service_attribute_id" => $service_attribute->id
                    ]);
                    break;

                case 'CHECK':
                case 'RADIO':
                    foreach ($validatedBody['value'] as $value) {
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
                "service_id" => $validatedBody['service_id'],
            ]);
            return $service_attribute;
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceAttribute $serviceAttribute)
    {
        return $serviceAttribute;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceAttributeRequest $request, int $id)
    {
        // if the type needs changing then the admin will have to delete it first and then add it again.
        // todo: the type Can't be changed (or if some some reason it needs changing, then all it's values needs to be deleted first)

        $validatedBody = $request->validated();
        return ServiceAttribute::where('id', $id)->update(['label' => $validatedBody['label']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // Todo: needs further analyzing, because services are related to orders, so there should be restrictions on deletion (prevening it or resulting to soft deletion)
        return DB::transaction(function() use ($id){
            ServiceValue::where('service_attribute_id', $id)->delete();
            return ServiceAttribute::where('id', $id)->delete();
        });
    }
}
