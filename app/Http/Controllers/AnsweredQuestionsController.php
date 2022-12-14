<?php

namespace App\Http\Controllers;

use App\Services\AnsweredQuestionsService;
use App\Services\AnsweredQuizzesService;
use App\Services\QuestionsService;
use Illuminate\Http\Request;

class AnsweredQuestionsController extends Controller
{
    /**
     * Using dependency injection to inject services
     */
    public function __construct(
        private QuestionsService $questionsService,
        private AnsweredQuestionsService $answeredQuestionsService,
        private AnsweredQuizzesService $answeredQuizzesService,
    ) {
    }

    /**
     * Show the page to answer a question from a playing quiz
     */
    public function show(int $quiz, int $question, int $answered_quiz = null)
    {
        // If there is an answered quiz, check that the current answered question
        // belongs to the latest answered quiz of the authenticated user
        if ($answered_quiz && ! $this->isLastAnsweredQuizOfAuthUser($answered_quiz)) {
            abort(403);
        }

        return view('play.questions.show', [
            'quiz_id' => $quiz,
            'question' => $this->questionsService->getQuestionWithAnswersAndImage($question),
            'answered_quiz_id' => $answered_quiz,
        ]);
    }

    /**
     * Store the answered question from a playing quiz
     */
    public function store(Request $request, int $quiz, int $question, int $answered_quiz = null)
    {
        // If there is an answered quiz, check that the current answered question
        // belongs to the latest answered quiz of the authenticated user
        if ($answered_quiz && ! $this->isLastAnsweredQuizOfAuthUser($answered_quiz)) {
            abort(403);
        }

        $request->request->add(['question_id' => $question, 'answered_quiz_id' => $answered_quiz]);

        $answered_quiz = $this->answeredQuestionsService->save($request)->answered_quiz_id;

        $nextQuestion = $this->questionsService->getNextQuestionWithAnswers($quiz, $question);

        if ($nextQuestion) {
            return redirect(route('play.questions.show', [
                'quiz' => $quiz,
                'question' => $nextQuestion,
                'answered_quiz' => $answered_quiz,
            ]));
        } else {
            return redirect(route('play.show', [
                'quiz' => $quiz,
                'answered_quiz' => $answered_quiz,
            ]));
        }
    }

    private function isLastAnsweredQuizOfAuthUser(int $answered_quiz): bool
    {
        return $this->answeredQuizzesService->getMaxAnsweredQuizIdFromAuthUser() === $answered_quiz;
    }
}
