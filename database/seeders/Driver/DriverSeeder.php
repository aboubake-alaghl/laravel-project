<?php

namespace Database\Seeders\Driver;

use App\Models\Driver\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Driver::create([
            "first_name" => "Jhon",
            "last_name" => "Dou",
            "email"  => "driver.test@test.com",
            "phone"  => "944000044",
            "password"  => "strongpassword123",
            "dob" => "1990-05-20",
            "passport_no" => " 123123123",
            "criminal_case" => "123123123",
            "national_no" => "123123123",
            "delivery_status"  => "AVAILABLE",
            "status" => "LATER"
        ]);
    }
}
