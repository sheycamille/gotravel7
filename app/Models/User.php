<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    const ROLE_ADMIN = 'administrator';
    const ROLE_DRIVER = 'driver';
    const ROLE_PASSENGER = 'passenger';
    const LANG_EN = 'english';
    const LANG_FR = 'french';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    protected $fillable = [
        'first_name', 'last_name', 'username', 'name', 'email', 'email_verified_at', 'password', 'phone_number', 'type', 'nic', 'primary_address', 'dob', 'language', 'status', 'points', 'avatar', 'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $dates = ['deleted_at'];

    public function getName()
    {
        return $this->name ? $this->name : $this->username;
    }

    /*public static function getUserTypes()
    {
        return ['passenger', 'driver', 'administrator'];
    }*/
    public function isAdmin()
    {

        return $this->type === User::ROLE_ADMIN;
    }

    public function isUser()
    {

        return $this->type === User::ROLE_DRIVER || User::ROLE_PASSENGER;
        
    }

    public static function getUserGenders()
    {
        return [User::GENDER_MALE, User::GENDER_FEMALE];
    }

    public static function getUserLanguages()
    {
        return [User::LANG_EN, User::LANG_FR];
    }

    public function rides()
    {
        return $this->hasMany(Ride::class);
    }

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'owner_id');
    }
}
