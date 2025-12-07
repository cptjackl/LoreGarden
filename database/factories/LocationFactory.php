<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'image' => "https://picsum.photos/id/{$this->faker->numberBetween(1, 100)}/200",
            'creator' => $this->faker->numberBetween(1, 4)
        ];
    }
}
