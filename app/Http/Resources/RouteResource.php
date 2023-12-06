<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
       // return parent::toArray($request);
    }
}
