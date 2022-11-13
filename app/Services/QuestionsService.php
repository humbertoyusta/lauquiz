<?php

namespace App\Services;

use App\Models\Question;

class QuestionsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct('\App\Models\Question');
    }

    public function getQuestionWithAnswers (int $id)
    {
        return Question::where('id', $id)->with('answers')->first();
    }
}
