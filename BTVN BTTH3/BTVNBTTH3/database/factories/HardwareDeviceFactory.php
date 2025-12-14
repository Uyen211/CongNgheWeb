<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HardwareDevice>
 */
class HardwareDeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'device_name' => fake()->word() . ' Device',
            'type' => fake()->randomElement(['Mouse', 'Keyboard', 'Headset']),
            'status' => fake()->boolean(),
            'center_id' => \App\Models\ItCenter::factory(),
        ];
    }
}
