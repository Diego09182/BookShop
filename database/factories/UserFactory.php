<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
            'account' => $this->faker->unique()->userName(),
            'password' => bcrypt('password'),
            'avatar' => $this->faker->imageUrl(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'cellphone' => $this->faker->unique()->phoneNumber(),
            'birthday' => $this->faker->date(),
            'times' => 0,
            'administration' => 0,
            'ip_address' => $this->faker->ipv4(),
            'business_name' => $this->faker->company(),
            'business_description' => $this->faker->paragraph(),
            'product_quantity' => 0,
            'business_address' => $this->faker->address(),
            'business_website' => $this->faker->url(),
            'status' => 1,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
