<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'image' => "https://picsum.photos/id/{$this->faker->numberBetween(1, 100)}/200",
            'location' => Location::inRandomOrder()->first()?->id, // Pick from existing locations or null
            'creator' => $this->faker->numberBetween(1, 4)
        ];
    }
}
