<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'first_name' => $this->faker->firstName(),
            // 'last_name' => $this->faker->lastName(),
            // 'email' => $this->faker->email(),
            // 'email_verified_at' => $this->faker->dateTime(),
            // 'username' => $this->faker->userName(),
            // 'password' => Hash::make('Secret'),
            // 'phone_number' => $this->faker->phoneNumber(),
            // 'nic' => '11111',
            // 'primary_address' => $this->faker->address(),
            // 'dob' => $this->faker->date(),
            // 'gender' => $this->faker->randomElement(['M', 'F']),
            // 'points' => $this->faker->randomNumber(),
            // 'language' => $this->faker->languageCode(),
            // 'status' => $this->faker->randomElement([0, 1]),
            // 'avatar' => $this->faker->imageUrl(),
            // 'type' => $this->faker->randomElement(['driver', 'passenger', 'administrator']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
