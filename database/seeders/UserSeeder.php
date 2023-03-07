<?php

namespace Database\Seeders;


use Carbon\Carbon;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // default admin
        DB::table('users')->insert([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@gokamz.com',
            'username' => 'admin',
            'password' => Hash::make('test12345'),
            'primary_address' => 'SouthWest,buea',
            'status' => '0',
            'type' => 'administrator',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
