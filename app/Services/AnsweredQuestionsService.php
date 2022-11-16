<?php

namespace App\Services;

class AnsweredQuestionsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            '\App\Models\AnsweredQuestion',
            [
                'answer_id' => 'required|min:1|integer',
                'question_id' => 'required|min:1|integer',
                'answered_quiz_id' => 'nullable|min:1|integer',
            ],
        );
    }
}
