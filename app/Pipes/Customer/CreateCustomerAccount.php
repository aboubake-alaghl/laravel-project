<?php

namespace App\Pipes\Customer;

use App\Services\CustomerService;
use Closure;
use Exception;

class CreateCustomerAccount
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the process of creating a new driver account.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $customerService = new CustomerService();
        try {
            $customer = $customerService->storeCustomer($request->validated());

            $token = $customer->createToken(time())->plainTextToken;

            $request->merge([
                'id' => $customer->id,
                'token' => $token,
                'customer' => collect($customer)
            ]);

            return $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
