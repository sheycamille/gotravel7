<?php

namespace Database\Seeders;

use App\Models\RouteDirection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteDirectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFilePath = database_path( '/seeders/seeds/route_direction.json');
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if ($data) {
            foreach ($data as $propertyData) {
                RouteDirection::create([
                    "to" => $propertyData['to'],
                    "from" => $propertyData['from'],
                    "distance" => $propertyData['distance'],
                    "status" => $propertyData['status'],
                ]);
            }
        }
    }
}
