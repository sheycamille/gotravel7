<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Route;

class RideResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver' => $this->driver(),
            'pickupLocation' => $this->pickup_location,
            'numOfSeats' => $this->num_of_seats ?? 0,
            'availableSeats' => $this->spacesLeft(),
            'type' => $this->type,
            'status' => $this->status,
            "destination" => Route::where("id", $this->destination)->first()->name,
            "departure" => Route::where("id", $this->departure)->first()->name,
            'departureDay' => $this->start_day,
            'departureTime' => $this->start_time,
            'comments' => $this->comments,
            'pricePerSeat' => $this->cost,
            'carModel' => $this->car_model,
            'carNumberPlate' => $this->car_number_plate,
            'spacesLeft' => $this->spacesLeft(),
            // 'isAPassenger' => $this->isAPassenger(),
            'carImages' => $this->carImages->map(function ($image) {
                return $image->url ? (strpos($image->url, 'http://') === 0 || strpos($image->url, 'https://') === 0 ? $image->url : url("storage/".$image->url)) : url("assets/images/1498105293-69-droppin-technologies-ltd.jpg");
            }),
            'passengers' => $this->bookings->map(function ($booking) {return [ 'first_name' => $booking->passenger->first_name, 'last_name' => $booking->passenger->last_name,];})->toArray()
        ];
    }
}