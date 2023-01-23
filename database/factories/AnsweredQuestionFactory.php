<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\AnsweredQuiz;
use App\Models\Question;
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
        if (Question::count() >= DatabaseSeeder::QUESTIONS_AMOUNT)
            $question_id = rand(1, DatabaseSeeder::QUESTIONS_AMOUNT);
        else
            $question_id = Question::factory()->create()->id;

        if (Answer::count() >= DatabaseSeeder::ANSWERS_AMOUNT)
            $answer_id = rand(1, DatabaseSeeder::ANSWERS_AMOUNT);
        else
            $answer_id = Answer::factory()->create()->id;

        if (AnsweredQuiz::count() >= DatabaseSeeder::ANSWERED_QUIZZES_AMOUNT)
            $answered_quiz_id = rand(1, DatabaseSeeder::ANSWERED_QUIZZES_AMOUNT);
        else
            $answered_quiz_id = AnsweredQuiz::factory()->create()->id;

        return [
            'answered_quiz_id' => $answered_quiz_id,
            'question_id' => $question_id,
            'answer_id' => $answer_id,
            'is_correct' => rand(0, 1),
        ];
    }
}
