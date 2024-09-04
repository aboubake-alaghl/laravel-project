<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Tripoli',
                'lat' => 32.8854,
                'lng' => 13.1800,
                'rad' => 15.0,
            ],
            [
                'name' => 'Benghazi',
                'lat' => 32.1167,
                'lng' => 20.0667,
                'rad' => 12.5,
            ],
            [
                'name' => 'Sabha',
                'lat' => 27.0377,
                'lng' => 14.4283,
                'rad' => 10.0,
            ],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
