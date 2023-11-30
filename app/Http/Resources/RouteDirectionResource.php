<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteDirectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'to' => $this->to,
            'from' =>$this->from,
            'status' =>$this->status,
            'distance' => $this->distance,
        ];
       // return parent::toArray($request);
    }
}
