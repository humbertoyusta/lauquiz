<?php

namespace App\Services;

class AnswersService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            '\App\Models\Answer',
            [
                'content' => 'required',
                'question_id' => 'required|min:1|integer',
                'is_correct' => 'required|boolean',
            ],
        );
    }
}
