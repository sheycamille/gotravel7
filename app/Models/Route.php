<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = "active";
    const STATUS_SUSPENDED = "suspended";
    

    protected $fillable = [
        "name",
        "status",
    ];

        
    public function Ride()
    {
        return $this->hasOne(Ride::class);
    }

}
