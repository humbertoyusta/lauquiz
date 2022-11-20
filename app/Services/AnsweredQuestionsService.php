<?php

namespace App\Services;

use App\Models\Answer;
use Illuminate\Http\Request;

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
                'is_correct' => 'required|boolean',
            ],
        );
    }

    public function save(Request $request, int $id = 0)
    {
        $request->request->add(['is_correct' => Answer::find($request->answer_id)->is_correct]);

        return parent::save($request, $id);
    }
}
