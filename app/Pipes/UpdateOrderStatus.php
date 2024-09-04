<?php

namespace App\Pipes;

use Closure;
use App\Services\OrderService;
use App\Services\DriverService;
use Exception;

class UpdateOrderStatus
{
    protected $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function handle($request, Closure $next)
    {
        try {
            if (!$request->is_paid) {
                $this->orderService->updatePaymentStatus($request->id);
            }
            $this->orderService->updateStatus($request->id, 'DELIVERED');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
