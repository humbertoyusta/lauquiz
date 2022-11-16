<?php

namespace App\Http\Controllers;

use App\Services\AnsweredQuestionsService;
use App\Services\AnsweredQuizzesService;
use App\Services\QuestionsService;
use App\Services\QuizzesService;
use Illuminate\Http\Request;

class PlayQuizController extends Controller
{
    public function __construct(
        private QuizzesService $quizzesService,
        private QuestionsService $questionsService,
        private AnsweredQuestionsService $answeredQuestionsService,
        private AnsweredQuizzesService $answeredQuizzesService,
    )
    {}

    public function index ()
    {
        return view('play.index', [
            'quizzes' => $this->quizzesService->getQuizzesWithQuestions(),
        ]);
    }

    public function show (int $quiz, int $answered_quiz) {
        return view('play.show', [
            'quiz' => $this->quizzesService->get($quiz),
            'performance' => $this->answeredQuizzesService->performance($answered_quiz),
        ]);
    }

    public function questionsShow (int $quiz, int $question, int $answered_quiz = null)
    {
        return view('play.questions.show', [
            'quiz_id' => $quiz,
            'question' => $this->questionsService->getQuestionWithAnswers($question),
            'answered_quiz_id' => $answered_quiz,
        ]);
    }

    public function questionsStore (Request $request, int $quiz, int $question, int $answered_quiz = null)
    {
        $request->request->add(['question_id' => $question, 'answered_quiz_id' => $answered_quiz]);

        $answered_quiz = $this->answeredQuestionsService->save($request)->answered_quiz_id;

        $nextQuestion = $this->questionsService->getNextQuestionWithAnswers($quiz, $question);

        if ($nextQuestion)
        {
            return redirect(route('play.questions.show', [
                'quiz' => $quiz,
                'question' => $nextQuestion,
                'answered_quiz' => $answered_quiz,
            ]));
        }
        else {
            return redirect(route('play.show', [
                'quiz' => $quiz,
                'answered_quiz' => $answered_quiz,
            ]));
        }
    }
}
