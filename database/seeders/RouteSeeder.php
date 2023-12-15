<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteDirection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Route::factory()->count(10)->create();
    }
}
