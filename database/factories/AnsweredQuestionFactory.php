<?php

namespace Database\Factories;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnsweredQuestion>
 */
class AnsweredQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'answered_quiz_id' => rand(1, DatabaseSeeder::ANSWERED_QUIZZES_AMOUNT),
            'question_id' => rand(1, DatabaseSeeder::QUESTIONS_AMOUNT),
            'answer_id' => rand(1, DatabaseSeeder::ANSWERS_AMOUNT),
            'is_correct' => rand(0, 1),
        ];
    }
}
