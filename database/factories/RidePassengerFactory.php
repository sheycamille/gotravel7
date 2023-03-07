<?php

namespace Database\Factories;

use App\Models\Ride;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RidePassenger>
 */
class RidePassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ride_id' => Ride::factory(),
            'passenger_id' => User::factory(),
            'paid' => $this->faker->randomElement(['pending', 'completed']),
            'type' => $this->faker->randomElement(['persons', 'goods']),
            'status' => $this->faker->randomElement(['in_process', 'in_progress', 'ended', 'cancelled'])
        ];
    }
}
