<?php

namespace App\Http\Controllers;

use App\Services\AnsweredQuestionsService;
use App\Services\AnsweredQuizzesService;
use App\Services\QuestionsService;
use App\Services\QuizzesService;
use Illuminate\Http\Request;

class PlayQuizController extends Controller
{
    public const PER_PAGE = 5;

    public function __construct(
        private QuizzesService $quizzesService,
        private QuestionsService $questionsService,
        private AnsweredQuestionsService $answeredQuestionsService,
        private AnsweredQuizzesService $answeredQuizzesService,
    )
    {}

    /**
     * Displays the playable Quizzes
     */
    public function index ()
    {
        return view('play.index', [
            'quizzes' => $this->quizzesService->getNonDraftQuizzesWithQuestionsAndTags($this::PER_PAGE),
        ]);
    }

    /**
     * Displays the page of finished quiz with performance
     */
    public function show (int $quiz, int $answered_quiz) {
        return view('play.show', [
            'quiz' => $this->quizzesService->get($quiz),
            'answeredQuiz' => $this->answeredQuizzesService->getWithPerf($answered_quiz),
        ]);
    }
}
