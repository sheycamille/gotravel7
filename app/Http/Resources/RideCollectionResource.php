<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RideCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->map(function ($ride) {
            return new RideResource($ride);
        })->toArray();
    }
}
