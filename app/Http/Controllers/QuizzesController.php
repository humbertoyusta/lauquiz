<?php

namespace App\Http\Controllers;

use App\Services\AnsweredQuizzesService;
use App\Services\QuizzesService;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public const PER_PAGE = 5;

    /**
     * Injecting the Service to handle the business logic
     */
    public function __construct(
        private QuizzesService $quizzesService,
        private AnsweredQuizzesService $answeredQuizzesService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('quizzes.index', [
            'quizzes' => $this->quizzesService->currentUserQuizzesWithTags($this::PER_PAGE),
            'alertMessage' => $request->query('alertMessage'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $quiz = $this->quizzesService->save($request);

        return view('quizzes.edit', ['quiz' => $quiz]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return view('quizzes.show', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($id),
        ]);
    }

    /**
     * Display the scoreboard of all the users that answered a Quiz
     */
    public function scoreboard(int $id) 
    {
        $answeredQuizzes = $this->answeredQuizzesService->paginateFromQuizWithPerfAndUser($id, $this::PER_PAGE);

        return view('quizzes.scoreboard', ['answeredQuizzes' => $answeredQuizzes]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('quizzes.edit', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $this->quizzesService->save($request, $id);

        return view('quizzes.edit', ['quiz' => $this->quizzesService->getQuizwithQuestions($id)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->quizzesService->delete($id);

        return redirect(route('quizzes.index', ['alertMessage' => 'Deleted succesfully']));
    }
}
