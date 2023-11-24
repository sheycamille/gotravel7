<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //mobile money
        DB::table('payment_methods')->insert([
            'name' => 'mobile money',
            'logo' => '',
            'min' => '1000',
            'max' => '20000',
            'description' => 'book rides using mtn monbile money',
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        //orange money
        DB::table('payment_methods')->insert([
            'name' => 'orange money',
            'logo' => '',
            'min' => '1000',
            'max' => '20000',
            'description' => 'book rides using orange money',
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);
    }
}
