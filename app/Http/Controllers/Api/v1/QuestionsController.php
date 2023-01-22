<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class QuestionsController extends Controller
{
    public const PER_PAGE = 5;

    public function __construct ()
    {
        $this->authorizeResource(Question::class, 'question');
    }

    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions()->with(['answers'])->get();

        return QuestionResource::collection($questions);
    }

    public function store(QuestionRequest $request, Quiz $quiz)
    {
        $question = Question::create([...$request->validated(), 'quiz_id' => $quiz->id]);

        return QuestionResource::make($question);
    }

    public function show(Quiz $quiz, Question $question)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);

        return QuestionResource::make($question);
    }

    public function update(QuestionRequest $request, Quiz $quiz, Question $question)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);

        $question->update($request->validated());

        return QuestionResource::make($question);
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);

        $question->delete();

        return QuestionResource::make($question);
    }

    private function ensureQuestionIsInQuiz (Question $question, Quiz $quiz): void {
        if ($question->quiz_id !== $quiz->id)
            throw new UnprocessableEntityHttpException('Question does not belong to quiz');
    }
}
