<?php

namespace App\Pipes;

use App\Services\OrderService;
use App\Models\Customer\Customer;
use App\Notifications\StuffTransferred;
use Illuminate\Support\Facades\Notification;

class OrderDeliveredNotification
{
    protected $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function handle($request, $next)
    {
        $serviceType = $this->orderService->getServiceType($request->id);
        // TODO: Send notification to customer depending on service type. We will send 
        // StuffTransfered to customer for now.
        Notification::send(Customer::find($request->customer_id), new StuffTransferred($request->id));
    }
}
