<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total = 0;

        while ($total < DatabaseSeeder::QUIZ_TAGS_AMOUNT)
        {
            $quiz = Quiz::find(rand(1, DatabaseSeeder::QUIZZES_AMOUNT));
            
            $tag_id = rand(1, DatabaseSeeder::TAGS_AMOUNT);
            if (!$quiz->tags()->where('tag_id', $tag_id)->exists())
            {
                $quiz->tags()->attach($tag_id);
                $total ++;
            }
        }
    }
}
