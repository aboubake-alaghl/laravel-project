<?php

namespace App\Http\Controllers\Driver;

use App\Pipes\ConfirmOtp;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\DriverService;
use App\Pipes\UpdateOrderStatus;
use App\Http\Controllers\Controller;
use App\Pipes\UploadOrderProofImage;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Response;
use App\Pipes\OrderDeliveredNotification;


class DeliveryController extends Controller
{
    protected $driverService;
    protected $orderService;

    public function __construct()
    {
        $this->driverService = new DriverService();
        $this->orderService = new OrderService();
    }

    /**
     * Updates the delivery status of a driver.
     *
     * @param Request $request 
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Exception
     */
    public function updateDeliveryStatus(Request $request)
    {
        try {
            $this->driverService->updateDeliveryStatus(
                $request->user()->id,
                $request->delivery_status
            );
            return Response::ok(['message' => 'Delivery status updated']);
        } catch (\Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Updates the order status to 'dispatched'.
     *
     * @param Request $request The incoming request containing the order ID.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response indicating success or failure.
     * @throws \Exception Throws an exception if any error occurs during the process.
     */
    public function pickupOrder(Request $request)
    {
        try {
            $this->orderService->markAsDispatched($request->id);
            return Response::updated('Order status updated');
        } catch (\Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Confirms the order by validating the OTP, updating the order status, uploading the proof image,
     * and send notifications to the customer via database.
     *
     * @param Request $request The incoming request containing the order details and OTP.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response indicating success or failure.
     * @throws \Exception Throws an exception if any error occurs during the process.
     */
    public function confirmOrder(Request $request)
    {
        try {
            Pipeline::send($request)
                ->through([
                    ConfirmOtp::class,
                    UpdateOrderStatus::class,
                    UploadOrderProofImage::class,
                    OrderDeliveredNotification::class
                ])
                ->thenReturn();
            return Response::ok(['message' => 'Order is confirmed']);
        } catch (\Exception $e) {
            return Response::exception($e);
        }
    }
}
