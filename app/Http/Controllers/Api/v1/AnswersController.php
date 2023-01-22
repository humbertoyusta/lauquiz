<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AnswersController extends Controller
{
    public function __construct ()
    {
        //$this->authorizeResource(Answer::class, 'answer');
    }

    public function index(Quiz $quiz, Question $question)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);

        return AnswerResource::collection($question->answers);
    }

    public function store(AnswerRequest $request, Quiz $quiz, Question $question)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);

        $answer = Answer::create([...$request->validated(), 'question_id' => $question->id]);

        return AnswerResource::make($answer);
    }

    public function show(Quiz $quiz, Question $question, Answer $answer)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);
        $this->ensureAnswerIsInQuestion($answer, $question);

        return AnswerResource::make($answer);
    }

    public function update(AnswerRequest $request, Quiz $quiz, Question $question, Answer $answer)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);
        $this->ensureAnswerIsInQuestion($answer, $question);

        $answer->update($request->validated());

        return AnswerResource::make($answer);
    }

    public function destroy(Quiz $quiz, Question $question, Answer $answer)
    {
        $this->ensureQuestionIsInQuiz($question, $quiz);
        $this->ensureAnswerIsInQuestion($answer, $question);

        $answer->delete();

        return AnswerResource::make($answer);
    }

    private function ensureQuestionIsInQuiz (Question $question, Quiz $quiz): void {
        if ($question->quiz_id !== $quiz->id)
            throw new UnprocessableEntityHttpException('Question does not belong to quiz');
    }

    private function ensureAnswerIsInQuestion (Answer $answer, Question $question): void {
        if ($answer->question_id !== $question->id)
            throw new UnprocessableEntityHttpException('Answer does not belong to question');
    }
}
