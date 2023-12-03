<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'url'
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'owner_id');
    }
    
}

