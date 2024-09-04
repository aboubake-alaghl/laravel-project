<?php

namespace App\Http\Controllers\Order;
use App\Http\Controllers\Controller;

use App\Models\Order\OrderPriceFactor;
use App\Http\Requests\StoreOrderPriceFactorRequest;
use App\Http\Requests\UpdateOrderPriceFactorRequest;

class OrderPriceFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderPriceFactorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderPriceFactor $orderPriceFactor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderPriceFactor $orderPriceFactor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderPriceFactorRequest $request, OrderPriceFactor $orderPriceFactor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderPriceFactor $orderPriceFactor)
    {
        //
    }
}
