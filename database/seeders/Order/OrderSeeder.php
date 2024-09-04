<?php

namespace Database\Seeders\Order;

use App\Models\Order\Order;
use App\Models\Order\Recipient;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::create([
            "description" => "test",
            "customer_id" => 1,
            "service_id" => 1,
            "from_address_id" => 1,
            "to_address_id" => 1,
        ]);

        Recipient::create([
            "order_id" => $order->id,
            "name" => "recipient_test",
            "phone" => "091123123",
            "note" => "recipient_test_note"
        ]);
    }
}
