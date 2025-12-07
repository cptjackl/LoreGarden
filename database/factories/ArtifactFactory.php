<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artifact>
 */
class ArtifactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'location' => Location::inRandomOrder()->first()?->id, // Pick from existing locations or null
            'image' => "https://picsum.photos/id/{$this->faker->numberBetween(1, 100)}/200",
            'owner' => Character::inRandomOrder()->first()?->id, // Pick from existing characters or null
            'creator' => $this->faker->numberBetween(1, 4)
        ];
    }
}
