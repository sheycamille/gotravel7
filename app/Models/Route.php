<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        "to",
        "from",
        "status",
        "distance",
        "created_at",
        "updated_at",
        ];

        
    public function Ride()
    {
        return $this->hasOne(Ride::class);
    }

}
