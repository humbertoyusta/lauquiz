<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const USERS_AMOUNT = 10;

    const QUIZZES_AMOUNT = 20;

    const QUESTIONS_AMOUNT = 40;

    const ANSWERS_AMOUNT = 120;

    const ANSWERED_QUIZZES_AMOUNT = 40;

    const ANSWERED_QUESTIONS_AMOUNT = 120;

    const TAGS_AMOUNT = 10;

    const QUIZ_TAGS_AMOUNT = 40;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            QuizSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            AnsweredQuizSeeder::class,
            AnsweredQuestionSeeder::class,
            TagSeeder::class,
            QuizTagSeeder::class,
        ]);
    }
}
