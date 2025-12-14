<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'director' => fake()->name(),
            'release_date' => fake()->date(),
            'duration' => fake()->numberBetween(90, 180),
            'cinema_id' => \App\Models\Cinema::factory(),
        ];
    }
}
