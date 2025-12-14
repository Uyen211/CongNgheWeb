<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laptop>
 */
class LaptopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand' => fake()->company(),
            'model' => fake()->word() . ' ' . fake()->randomNumber(3),
            'specifications' => 'i5, 8GB RAM, 256GB SSD',
            'rental_status' => fake()->boolean(),
            'renter_id' => \App\Models\Renter::factory(),
        ];
    }
}
