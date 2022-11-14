<?php

namespace App\Services;

use App\Models\Quiz;

class QuizzesService extends AbstractService
{
    public function __construct() {
        parent::__construct(
            '\App\Models\Quiz',
            [
                'title' => 'required|max:255',
            ],
        );
    }

    public function getQuizwithQuestionsAndAnswers(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions' => ['answers']])->first();
    }

    public function getQuizwithQuestions(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions'])->first();
    }
}
