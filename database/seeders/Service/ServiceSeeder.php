<?php

namespace Database\Seeders\Service;

use App\Models\Service\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Service::create([
            "name" => "وصلي"
        ]);

        Service::create([
            "name" => "نقل اثاث"
        ]);
    }
}
