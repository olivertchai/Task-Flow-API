<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => $this->faker->paragraph(),
            'phone' => $this->faker->phoneNumber(),
            'avatar_url' => $this->faker->imageUrl(200, 200, 'people'),
        ];
    }
}
