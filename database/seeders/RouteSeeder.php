<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteDirection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{

    public function run(): void
    {

        $jsonFilePath = database_path( '/seeders/seeds/route.json');
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if ($data) {
            foreach ($data as $cat) {
                Route::create([
                    "name" => $cat["name"],
                    "status" => $cat["status"],
                ]);
            }
        }

    }
    
}
