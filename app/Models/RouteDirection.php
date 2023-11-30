<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteDirection extends Model
{
    use HasFactory;

    protected $fillable = [
        "to",
        "from",
        "status",
        "distance"
    ];

    public function Ride()
    {
        return $this->hasOne(Ride::class);
    }

}
