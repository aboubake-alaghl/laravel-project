<?php

namespace App\Services;

use Exception;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Order\OrderProofImage;
use App\Models\Order\Recipient;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    /**
     * creates order.
     *
     * @param Order $order The order instance.
     * @return Order
     *
     * @throws Exception
     */
    public function createOrder($order)
    {
        try {
            return DB::transaction(function () use ($order) {
                $createdOrder = Order::create($order);
                Recipient::create([
                    "name" => $order['recipient']['name'],
                    "phone" => $order['recipient']['phone'],
                    "note" => $order['recipient']['note'] ?? null,
                    "order_id" => $createdOrder->id,
                ]);
                return $createdOrder;
            });
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * creates order.
     *
     * @param Order $order The order instance.
     * @return Order
     *
     * @throws Exception
     */
    public function addRecipient(int $order_id)
    {
        try {
            return Recipient::create([]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates the order status.
     *
     * @param int|Order $order The order instance or id to update.
     * @param string $status The new status for the order.
     *
     * @return void
     *
     * @throws Exception
     */
    public function updateStatus($order, $status)
    {
        try {
            Order::where('id', $order)->update(['status' =>  $status]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Updates the payment status (is_paid) of the specified order.
     *
     * @param int $order Order instance or id.
     *
     * @return void
     *
     * @throws Exception
     */
    public function updatePaymentStatus($order)
    {
        try {
            Order::where('id', $order)->update(['is_paid' => true]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Uploads the order proof image to the storage.
     *
     * @param int|Order $order The order instance or id to associate the image with.
     * @param $image The uploaded image file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function uploadProofImage($order, $image)
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images/order-proof', $filename, 'public');

        try {
            OrderProofImage::create([
                'order_id' => $order,
                'url' => $path,
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getServiceType($order)
    {
        return Order::find($order)->service_type;
    }

    /**
     * Marks the orders with 'awaiting' status as 'dispatched'.
     *
     * @param mixed $order order id.
     *
     * @return void
     *
     * @throws Exception If an error occurs during the database transaction.
     */
    public function markAsDispatched($order)
    {
        try {
            Order::where('id', $order)
                ->where('status', 'awaiting')
                ->update(['status' => 'PICKED']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
