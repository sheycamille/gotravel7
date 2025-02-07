<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' =>$this->first_name,
            'last_name' =>$this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone_number,
            'nic' => $this->nic,
            'address' => $this->primary_address,
            'dob' => $this->dob,
            'gender'=> $this->gender,
            'points'=> $this->points,
            'language'=> $this->language,
            'status' => $this->status,
            'avatar' => $this->avatar,
            'type' => $this->type,
        ];
    }
}
