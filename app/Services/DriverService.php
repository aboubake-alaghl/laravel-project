<?php

namespace App\Services;

use Exception;
use App\Models\Driver\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DriverService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}
    /**
     * Filter drivers by the service requested in the order.
     *
     * @param int $status
     * @return array array of drivers.
     * @throws Exception 
     */
    public function filterDrivers(int $serviceId)
    {
        try {
            return Driver::where('is_active', true)->whereHas('services', function ($query) use ($serviceId) {
                $query->where('services.id', $serviceId);
            })->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Store a new driver record.
     *
     * @param array $data Driver data.
     * @return Driver Created driver instance.
     * @throws Exception If an error occurs during the transaction.
     */
    public function storeDriver($data)
    {
        try {
            return Driver::create(
                [
                    ...$data,
                    'password' => Hash::make($data['password']),
                ]
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates the delivery status of a driver instance.
     *
     * @param Driver|int $driver Driver instance or id.
     * @param string $status The new delivery status.
     * @return void
     * @throws Exception If an error occurs during the transaction. 
     */
    public function updateDeliveryStatus($driver, $status)
    {
        try {
            Driver::where('id', $driver)->update(['delivery_status' =>  $status]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates Driver password.
     *
     * @param Driver|int $driver The driver instance or id.
     * @param string $password The new password.
     * @return void
     * @throws Exception If an error occurs during the transaction.
     */
    public function updatePassword($driver, $password)
    {
        try {
            Driver::where('id', $driver)->update(['password' => Hash::make($password)]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
