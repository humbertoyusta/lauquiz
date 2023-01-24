<?php

namespace Database\Factories;

use App\Models\Question;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        if (Question::count() >= DatabaseSeeder::QUESTIONS_AMOUNT)
            $question_id = rand(1, DatabaseSeeder::QUESTIONS_AMOUNT);
        else
            $question_id = Question::factory()->create()->id;

        return [
            'question_id' => $question_id,
            'content' => fake()->text(),
            'is_correct' => fake()->boolean(50),
        ];
    }
}
