<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "to" => $this->faker->city(),
            "from" => $this->faker->city(),
            "status" => $this->faker->randomElement([0, 1]),
            "distance" => $this->faker->randomElement(['3km','5km','10km','2km']),
        ];
    }
}
