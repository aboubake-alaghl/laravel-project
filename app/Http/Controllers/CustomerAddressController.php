<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Http\Requests\StoreCustomerAddressRequest;
use App\Http\Requests\UpdateCustomerAddressRequest;

class CustomerAddressController extends Controller
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
    public function store(StoreCustomerAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerAddress $customerAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerAddress $customerAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerAddressRequest $request, CustomerAddress $customerAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerAddress $customerAddress)
    {
        //
    }
}
