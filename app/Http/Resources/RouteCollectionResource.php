<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteCollectionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return $this->map(function ($route) {
            return new RouteResource($route);
        })->toArray();
    }
}
