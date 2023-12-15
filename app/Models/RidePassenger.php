<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RidePassenger extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ride_id', 'passenger_id', 'type', 'paid', 'status', 'num_of_seats'
    ];

    protected $dates = ['deleted_at'];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
