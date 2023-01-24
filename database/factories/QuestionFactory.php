<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (User::count() >= DatabaseSeeder::QUIZZES_AMOUNT)
            $quiz_id = rand(1, DatabaseSeeder::QUIZZES_AMOUNT);
        else
            $quiz_id = Quiz::factory()->create()->id;

        return [
            'quiz_id' => $quiz_id,
            'content' => fake()->text(),
        ];
    }
}
