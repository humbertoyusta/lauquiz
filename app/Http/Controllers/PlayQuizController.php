<?php

namespace App\Http\Controllers;

use App\Services\QuestionsService;
use App\Services\QuizzesService;
use Illuminate\Http\Request;

class PlayQuizController extends Controller
{
    public function __construct(
        private QuizzesService $quizzesService,
        private QuestionsService $questionsService,
    )
    {}

    public function index ()
    {
        return view('play.index', [
            'quizzes' => $this->quizzesService->getQuizzesWithQuestions(),
        ]);
    }

    public function show (int $quiz) {
        return view('play.show', [
            'quiz' => $this->quizzesService->get($quiz),
        ]);
    }

    public function questionsShow (int $quiz, int $question)
    {
        return view('play.questions.show', [
            'quiz_id' => $quiz,
            'question' => $this->questionsService->getQuestionWithAnswers($question),
        ]);
    }

    public function questionsStore (Request $request, int $quiz, int $question)
    {
        $nextQuestion = $this->questionsService->getNextQuestionWithAnswers($quiz, $question);

        if ($nextQuestion)
        {
            return redirect(route('play.questions.show', [
                'quiz' => $quiz,
                'question' => $nextQuestion,
            ]));
        }
        else {
            return redirect(route('play.show', [
                'quiz' => $quiz,
            ]));
        }
    }
}
