<?php

namespace Database\Seeders\Customer;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            "first_name" => "John",
            "last_name" => "Doe",
            "password" => "strongpassword123",
            "email" => "john.doe@example.com",
            "phone" => "218944000088",
            "phone_code" => "218",
            "gender" => true,
            "dob" => "1990-05-20"
        ]);
    }
}
