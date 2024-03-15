<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        "ride_id",
        "passenger_id",
        "totalCost",
        "paymentMethod",
        "numberOfSeats",
        "transactionId",
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id');
    }

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    

}
