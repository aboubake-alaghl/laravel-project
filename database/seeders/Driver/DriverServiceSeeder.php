<?php

namespace Database\Seeders\Driver;

use App\Models\Driver\DriverService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DriverService::create([
            "service_id" => 1,
            "driver_id" => 1,
        ]);
    }
}
