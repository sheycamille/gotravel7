<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->map(function ($booking) {
            return new BookingResource($booking);
        })->toArray();
    }
}
