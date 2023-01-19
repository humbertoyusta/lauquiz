<?php

namespace App\Services;

use App\Models\Answer;
use Illuminate\Http\Request;

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

    public function save(Request $request, int $id = 0)
    {
        // Actually creating or updating the Question
        return parent::save($request, $id);
    }
}
