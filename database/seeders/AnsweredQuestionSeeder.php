<?php

namespace Database\Seeders;

use App\Models\AnsweredQuestion;
use Illuminate\Database\Seeder;

class AnsweredQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnsweredQuestion::factory(DatabaseSeeder::ANSWERED_QUESTIONS_AMOUNT)->createQuietly();
    }
}
