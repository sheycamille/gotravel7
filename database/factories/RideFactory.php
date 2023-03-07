<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ride>
 */
class RideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'driver_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'pickup_location' => $this->faker->streetName(),
            'num_of_seats' => $this->faker->randomNumber(1, true),
            'type' => $this->faker->randomElement(['people', 'goods']),
            'status' => $this->faker->randomElement(['in_process', 'started', 'ended']),
            'departure' => $this->faker->city(),
            'destination' => $this->faker->city(),
            'start_day' => $this->faker->date(),
            'start_time' => $this->faker->time(),
            'comments' => $this->faker->sentence(),
            'cost' => $this->faker->randomNumber(3, true),
            'charges' => $this->faker->randomNumber(2, true),
            'total_cost' => $this->faker->randomNumber(4, true)
        ];
    }
}
