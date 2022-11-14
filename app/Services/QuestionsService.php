<?php

namespace App\Services;

use App\Models\Question;

class QuestionsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            '\App\Models\Question',
            [
                'content' => 'required',
                'quiz_id' => 'required|integer|min:1',
            ],
        );
    }

    public function getQuestionWithAnswers (int $id)
    {
        return Question::where('id', $id)->with('answers')->first();
    }

    public function getNextQuestionWithAnswers (int $quizId, int $questionId)
    {
        return Question::where('quiz_id', $quizId)->where('id', '>', $questionId)->with('answers')->first();
    }
}
