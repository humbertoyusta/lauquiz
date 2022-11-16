<?php

namespace Database\Factories;

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
            'answered_quiz_id' => rand(1, 10),
            'question_id' => rand(1, 10),
            'answer_id' => rand(1, 30),
        ];
    }
}
