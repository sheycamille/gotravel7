<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RideResource extends JsonResource
{
    // "id": 3,
    // "driver_id": 0,
    // "pickupLocation": "ghh",
    // "availableSeats": 2,
    // "typeOfContent": "persons",
    // "status": "in_progress",
    // "departure": "Douala",
    // "destination": "Limbe",
    // "departureDay": "14/12/23",
    // "departureTime": "10:42 PM",
    // "comments": "fhhhj",
    // "pricePerSeat": 5000,
    // "carModel": "fhhjjj",
    // "carNumberPlate": "ghhjj",
    // "created_at": "2023-12-13T21:43:17.000000Z",
    // "updated_at": "2023-12-13T21:43:17.000000Z",
    // "deleted_at": null

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver' => $this->driver(),
            'pickupLocation' => $this->pickupLocation,
            'availableSeats' => $this->availableSeats,
            'typeOfContent' => $this->typeOfContent,
            'status' => $this->status,
            'departure' => $this->departure,
            'destination' => $this->destination,
            'departureDay' => $this->departureDay,
            'departureTime' => $this->departureTime,
            'comments' => $this->comments,
            'pricePerSeat' => $this->pricePerSeat,
            'carModel' => $this->carModel,
            'carNumberPlate' => $this->carNumberPlate,
            // 'passengers' => $this->passengers,
            'spacesLeft' => $this->spacesLeft(),
            'isAPassenger' => $this->isAPassenger(),
            'carImages' => $this->carImages->map(function ($image) {
                return $image->url ? (strpos($image->url, 'http://') === 0 || strpos($image->url, 'https://') === 0 ? $image->url : url("storage/".$image->url)) : url("assets/images/1498105293-69-droppin-technologies-ltd.jpg");
            }),
        ];
    }
}
