<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new \Faker\Provider\Fakecar($this->faker));
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->vehicle(),
            'plate_number' => $this->faker->vehicleRegistration(),
            'prod_year' => $this->faker->year(),
            'num_of_seats' => $this->faker->randomNumber(1, true),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement([0, 1]),
            'color' => $this->faker->colorName(),
            'brand' => $this->faker->vehicleBrand(),
            'type' => $this->faker->randomElement(['compact', 'pickup', 'pickup-truck', 'minivan', 'truck', 'jeep', 'luxury-car', 'mid-size', 'sports-car', 'taxi', 'bus', 'limousine', 'convertible', 'micro-car', 'hybrid', 'mini-van', 'sedan', 'coupe', 'van', 'dyna', 'suv', 'wagon', 'diesel', 'crossover']),
        ];
    }
}
