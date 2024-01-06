<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        
        "rideId",
        "passengerId",
        "feePaid",
        "paymentMethod",
        "numberOfSeats",
        "transacrtionId",

    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function passenger()
    {
        return $this->belongsTo(User::class);
    }

    

}
