<?php

namespace App\Http\Controllers;

use App\Services\QuestionsService;
use App\Services\QuizzesService;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Injecting the Service to handle the business logic
     */
    public function __construct(
        private QuestionsService $questionsService,
        private QuizzesService $quizzesService,
    ) {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $quiz)
    {
        return view('questions.create', [
            'quiz_id' => $quiz,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $quiz)
    {
        $request->request->add(['quiz_id' => $quiz]);

        $question = $this->questionsService->save($request);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question->id,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $quiz, int $question)
    {
        $question = $this->questionsService->getQuestionWithAnswersAndImage($question);

        if (!$question->canBeEditedBy())
            return redirect()->back();

        return view('questions.edit', [
            'quiz_id' => $quiz,
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $quiz, int $question)
    {
        $request->request->add(['quiz_id' => $quiz]);

        $this->questionsService->save($request, $question);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question,
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $quiz, int $question)
    {
        $this->questionsService->delete($question);

        return redirect(route('quizzes.edit', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($quiz),
        ]));
    }
}
