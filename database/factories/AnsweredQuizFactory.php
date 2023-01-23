<?php

namespace Database\Factories;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnsweredQuiz>
 */
class AnsweredQuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (User::count() >= DatabaseSeeder::USERS_AMOUNT)
            $user_id = rand(1, DatabaseSeeder::USERS_AMOUNT);
        else
            $user_id = User::factory()->create()->id;

        if (User::count() >= DatabaseSeeder::QUIZZES_AMOUNT)
            $quiz_id = rand(1, DatabaseSeeder::QUIZZES_AMOUNT);
        else
            $quiz_id = User::factory()->create()->id;

        return [
            'user_id' => $user_id,
            'quiz_id' => $quiz_id,
        ];
    }
}
