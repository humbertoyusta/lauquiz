<?php

namespace App\Services;

use App\Models\Quiz;

class QuizzesService extends AbstractService {
    public function __construct(
        public QuestionService $questionService,
    )
    {
        parent::__construct('\App\Models\Quiz');
    }

    public function getQuizwithQuestionsAndAnswers (int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions' => ['answers']])->first();
    } 
};