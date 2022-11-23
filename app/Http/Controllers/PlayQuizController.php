<?php

namespace App\Http\Controllers;

use App\Services\AnsweredQuestionsService;
use App\Services\AnsweredQuizzesService;
use App\Services\QuestionsService;
use App\Services\QuizzesService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PlayQuizController extends Controller
{
    public const PER_PAGE = 5;

    public function __construct(
        private QuizzesService $quizzesService,
        private QuestionsService $questionsService,
        private AnsweredQuestionsService $answeredQuestionsService,
        private AnsweredQuizzesService $answeredQuizzesService,
    ) {
    }

    /**
     * Displays the playable Quizzes
     */
    public function index()
    {
        $nonPaginatedQuizzes = Cache::remember(
            'play.index.allquizzes',
            config('app.cache_ttl'),
            function () {
                return $this->quizzesService->getNonDraftQuizzesWithQuestionsAndTags();
            },
        );

        $page = request()->get('page', 1);

        $paginatedQuizzes = new LengthAwarePaginator(
            $nonPaginatedQuizzes->forPage($page, $this::PER_PAGE),
            $nonPaginatedQuizzes->count(),
            $this::PER_PAGE,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()],
        );

        return view('play.index', ['quizzes' => $paginatedQuizzes]);
    }

    /**
     * Displays the page of finished quiz with performance
     */
    public function show(int $quiz, int $answered_quiz)
    {
        return view('play.show', [
            'quiz' => $this->quizzesService->get($quiz),
            'answeredQuiz' => $this->answeredQuizzesService->getWithPerf($answered_quiz),
        ]);
    }
}
