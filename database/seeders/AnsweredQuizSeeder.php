<?php

namespace Database\Seeders;

use App\Models\AnsweredQuiz;
use Illuminate\Database\Seeder;

class AnsweredQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnsweredQuiz::factory(DatabaseSeeder::ANSWERED_QUIZZES_AMOUNT)->create();
    }
}
