<?php

namespace App\Http\Controllers\Order;

use Exception;
use App\Models\Order\Order;
use App\Pipes\NotifyDrivers;
use App\Http\Controllers\Controller;
use App\Pipes\Order\CreateOrderPipe;
use App\Pipes\Order\FilterDriversPipe;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Order\StoreOrderRequest;

// function filterDrivers(int $service_id) {}

class OrderController extends Controller
{

    public function index() {}

    // 
    // Todo: Requires discussion because it involves multiple parts, for example.
    // a filter function should select the drivers that this order should appear to.
    // a function that should notify certain drivers (return of above mentioned filter function) only should run (by socket connection that the drivers are listening on, etc...).
    // a new table should be created called (OrderDriver) that houses which orders assigned to which drivers, also to help fetch orders for certain drivers. also later for history.
    // emails maybe needs to be sent also (e.g.. for customer confirming the creation for new order).
    // 
    public function store(StoreOrderRequest $request)
    {
        // 1- create a new order
        // 2- filter drivers
        // 3- notify drivers
        try {
            Pipeline::send($request)
                ->through([
                    CreateOrderPipe::class,
                    FilterDriversPipe::class,
                    NotifyDrivers::class
                ])
                ->thenReturn();

            return Response::created([
                'order' => $request->order
            ]);
            // return Response::created([
            //     'customer' => $request->customer,
            //     'token' => $request->token
            // ]);
        } catch (Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateOrderRequest $request, Order $order)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
