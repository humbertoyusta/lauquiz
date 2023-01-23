<?php

namespace Database\Factories;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (User::count() >= DatabaseSeeder::USERS_AMOUNT)
            $author_id = rand(1, DatabaseSeeder::USERS_AMOUNT);
        else
            $author_id = User::factory()->create()->id;

        return [
            'title' => ucfirst(fake()->word()),
            'author_id' => $author_id,
        ];
    }
}
