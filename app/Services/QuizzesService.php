<?php

namespace App\Services;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizzesService extends AbstractService
{
    public function __construct() {
        parent::__construct(
            '\App\Models\Quiz',
            [
                'title' => 'required|max:255',
                'author_id' => 'required|integer|min:1',
            ],
        );
    }

    public function save (Request $request, int $id = 0)
    {
        $request->request->add(['author_id' => Auth::user()->id]);

        return parent::save($request, $id);
    }

    public function paginate(int $perPage)
    {
        return Quiz::paginate($perPage);
    }

    public function getQuizwithQuestionsAndAnswers(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions' => ['answers']])->first();
    }

    public function getQuizwithQuestions(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions'])->first();
    }

    public function getQuizzesWithQuestions (int $perPage)
    {
        return Quiz::with(['questions'])->paginate($perPage);
    }
}
