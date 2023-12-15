<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        // default admin
        User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@gokamz.com',
            'username' => 'admin',
            'phone_number'=> '673572533',
            'password' => Hash::make('password'),
            'primary_address' => 'SouthWest,buea',
            'status' => '0',
            'type' => 'administrator',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // default admin
        User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'camille@gokamz.com',
            'username' => 'user',
            'phone_number'=> '5362526322',
            'password' => Hash::make('test12345'),
            'primary_address' => 'SouthWest,buea',
            'status' => '1',
            'type' => 'passenger',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
