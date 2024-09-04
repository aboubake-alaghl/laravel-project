<?php

namespace App\Services;

use App\Models\Customer\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Store a new customer record.
     *
     * @param array $data Customer data.
     * @return Customer Created Customer instance.
     * @throws Exception If an error occurs during the transaction.
     */
    public function storeCustomer($data)
    {
        try {
            return Customer::create([
                ...$data,
                'photo' => null,
                'password' => Hash::make($data['password']),
            ]);

            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates Customer password.
     *
     * @param Customer|int $customer The customer instance or id.
     * @param string $password The new password.
     * @return void
     * @throws Exception If an error occurs during the transaction.
     */
    public function updatePassword($customer, $password)
    {
        try {
            Customer::where('id', $customer)->update(['password' => Hash::make($password)]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
