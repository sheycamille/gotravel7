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
        "totalCost",
        "paymentMethod",
        "numberOfSeats",
        "transactionId",
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'rideId');
    }

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passengerId');
    }

    

}
