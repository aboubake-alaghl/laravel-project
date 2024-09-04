<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'name' => 'Tripoli Center',
                'lat' => 32.8896,
                'lng' => 13.1655,
                'zone_id' => 1, // Assuming this is the ID for Tripoli in the Zone table
            ],
            [
                'name' => 'Benghazi Downtown',
                'lat' => 32.1167,
                'lng' => 20.0667,
                'zone_id' => 2, // Assuming this is the ID for Benghazi in the Zone table
            ],
            [
                'name' => 'Sabha Main Square',
                'lat' => 27.0377,
                'lng' => 14.4283,
                'zone_id' => 3, // Assuming this is the ID for Sabha in the Zone table
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
