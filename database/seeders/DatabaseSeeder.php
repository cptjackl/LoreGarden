<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use App\Models\Character;
use App\Models\Artifact;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jack',
            'email' => 'jack@example.com',
            'password' => 'jackpassword'
        ]);

        User::factory()->create([
            'name' => 'Dan',
            'email' => 'dan@example.com',
            'password' => 'jackpassword'
        ]);

        User::factory()->create([
            'name' => 'Steven',
            'email' => 'steven@example.com',
            'password' => 'jackpassword'
        ]);

        User::factory()->create([
            'name' => 'Cody',
            'email' => 'cody@example.com',
            'password' => 'jackpassword'
        ]);

        Location::factory(5)->create();
        Character::factory(10)->create();
        Artifact::factory(25)->create();
    }
}
