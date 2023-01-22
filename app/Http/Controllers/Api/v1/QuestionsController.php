<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public const PER_PAGE = 5;

    public function __construct ()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    public function index()
    {
        $questions = Question::with(['quiz', 'answers'])->paginate(self::PER_PAGE);

        return QuestionResource::collection($questions);
    }

    public function store(QuestionRequest $request)
    {
        $question = Question::create($request->validated());

        return QuestionResource::make($question);
    }

    public function show(Question $question)
    {
        return QuestionResource::make($question);
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return QuestionResource::make($question);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return QuestionResource::make($question);
    }
}
