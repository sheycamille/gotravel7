<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ride extends Model
{
    use HasFactory;
    use SoftDeletes;

    const RIDE_STATUS_PROGRESS = 'in_progress';
    const RIDE_STATUS_STARTED = 'started';
    const RIDE_STATUS_ENDED = 'ended';
    const RIDE_TYPE_PERSONS = 'persons';
    const RIDE_TYPE_GOODS = 'goods';

    protected $fillable = [
        'departure',  
        'pickupLocation', 
        'destination', 
        'departureTime', 
        'departureDay', 
        'comments', 
        'pricePerSeat', 
        'availableSeats',
        'status', 
        'typeOfContent',
        'carModel',
        'carNumberPlate'
    ];

    protected $cast = [
        'carImages'=>'array'
    ];

    protected $dates = ['deleted_at'];

    public function driver()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function passengers()
    {
        return $this->hasMany('App\Models\RidePassenger');
    }

    public function isAPassenger()
    {
        return $this->belongsTo('App\Models\RidePassenger')->where('passenger_id', Auth::user()->id)->first();
    }

    public function spacesLeft()
    {
        return $this->num_of_seats - $this->passengers()->count();
    }

    public function getFullDate()
    {
        return $this->start_day . ' ' . $this->start_time;
    }

    public function getFullFormatedDate()
    {
        return date_format(date_create($this->getFullDate()), 'd M Y H:m:s');
    }

    public function setDepartureAttribute($value)
    {
        $this->attributes['departure'] = trim(strtolower($value));
    }

    /**
     * Always get the departure to uppercase when we display it
     */
    public function getDepartureAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always set the destination to lowercase when we save it to the database
     */
    public function setDestinationAttribute($value)
    {
        $this->attributes['destination'] = trim(strtolower($value));
    }

    /**
     * Always get the destination to lowercase when we display it
     */
    public function getDestinationAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always set the pickup_location to lowercase when we save it to the database
     */

    public function setPickupLocationAttribute($value)
    {
        $this->attributes['pickupLocation'] = trim(strtolower($value));
    }

    /**
     * Always get the pickup_location to lowercase when we display it
     */
    public function getPickupLocationAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Always set the start_day to lowercase when we save it to the database
     */
    public function setStartDayAttribute($value)
    {
        $this->attributes['departureDay'] = date_format(date_create($value), 'd-m-Y');
    }


    public function getRouteDirection(){
        return $this->departure . ' - ' . $this->destination;
    }
}
