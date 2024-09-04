<?php

namespace Database\Seeders;

use Database\Seeders\AddressSeeder;
use Database\Seeders\Customer\CustomerSeeder;
use Database\Seeders\Driver\DriverSeeder;
use Database\Seeders\Driver\DriverServiceSeeder;
use Database\Seeders\Service\ServiceSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seeders ordering is important (do not change order when editing)
        $this->call([
            ZoneSeeder::class,
            AddressSeeder::class,
            DriverSeeder::class,
            ServiceSeeder::class,
            DriverServiceSeeder::class,
            CustomerSeeder::class,
            // OrderSeeder::class
        ]);
        // seeders ordering is important (do not change order when editing)
    }
}
