<?php

namespace Database\Seeders;

use App\Models\RidePassenger;
use Illuminate\Database\Seeder;

class RidePassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RidePassenger::factory(10)->create();
    }
}
