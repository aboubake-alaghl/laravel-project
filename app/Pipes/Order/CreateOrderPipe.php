<?php

namespace App\Pipes\Order;

use App\Models\Order\Recipient;
use App\Services\OrderService;
use Closure;
use Exception;

class CreateOrderPipe
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the process of creating a new order.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        // order creation
        // filter driver (current_location (address))
        //  - by service 
        //  - by location (from (address))

        // price recummendation
        
        $orderService = new OrderService();
        try {
            $createdOrder = $orderService->createOrder($request->validated());

            $request->merge([
                'id' => $createdOrder->id,
                'order' => $createdOrder,
            ]);

            return $next($request);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
