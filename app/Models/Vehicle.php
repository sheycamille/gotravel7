<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    // use SoftDeletes; // TODO: Find out why this is needed


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'owner_id', 'plate_number', 'num_of_seats', 'description', 'color', 'brand', 'type', 'status', 'prod_year', 'cost_per_seat'
    ];

    protected $with = ['vehicleImages'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    protected $vehicleType = [
        'compact', 'pickup', 'pickup-truck', 'minivan', 'truck', 'jeep', 'luxury-car', 'mid-size', 'sports-car', 'taxi', 'bus', 'limousine', 'convertible', 'micro-car', 'hybrid', 'mini-van', 'sedan', 'coupe', 'van', 'dyna', 'suv', 'wagon', 'diesel', 'crossover'
    ];


    public function getvehicleType()
    {

        return $this->vehicleType;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');

    }

    public function vehicleImages()
    {
        return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
