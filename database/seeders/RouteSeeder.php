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
//     public function run(): void
//     {
//         $jsonFilePath = database_path( '/seeders/seeds/route.json');
//         $jsonData = file_get_contents($jsonFilePath);
//         $data = json_decode($jsonData, true);

//         if ($data) {
//             foreach ($data as $propertyData) {
//                 Route::create([
//                     "to" => $propertyData['to'],
//                     "from" => $propertyData['from'],
//                     "distance" => $propertyData['distance'],
//                     "status" => $propertyData['status'],
//                     "created_at" => $propertyData['created_at'],
//                     "updated_at" => $propertyData['updated_at'],
//                 ]);
//             }
//         }
 
//   }
//    }

public function run(): void
{
    $jsonFilePath = database_path('seeders/seeds/route.json');
    $jsonData = file_get_contents($jsonFilePath);
    $data = json_decode($jsonData, true);

    if ($data) {
        foreach ($data as $propertyData) {
            Route::create([
                'to' => $propertyData['to'],
                'from' => $propertyData['from'],
                'distance' => $propertyData['distance'],
                'status' => $propertyData['status'],
                
            ]);
        }
    }
}
}
 
