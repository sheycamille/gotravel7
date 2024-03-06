<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "totalCost" => $this->totalCost,
            "paymentMethod" => $this->paymentMethod,
            "ride" => new  \App\Http\Resources\RideResource(\App\Models\Ride::where("id", $this->ride_id)->first())
        ];
    }
}
