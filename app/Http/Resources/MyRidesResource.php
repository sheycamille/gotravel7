<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Route;
use App\Models\Booking;

class MyRidesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "destination" => Route::where("id", $this->destination)->first()->name,
            "departure" => Route::where("id", $this->departure)->first()->name,
            "departureDay" => $this->start_day,
            "departureTime" => $this->start_time,
            "pricePerSeat" => $this->cost,
            'status' => $this->status,
        ];
    }
}
