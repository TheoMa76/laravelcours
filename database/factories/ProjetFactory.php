<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projet>
 */
class ProjetFactory extends Factory
{

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['en_cours', 'termine', 'en_attente']),
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'user_id' => User::factory(),
            'goal' => $this->faker->numberBetween(100, 1000),
            'current_amount' => $this->faker->numberBetween(0, 100),
            'imagePath' => $this->faker->imageUrl()
        ];
    }
}
