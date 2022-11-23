<?php

namespace App\Http\Controllers;

use App\Services\AnswersService;
use App\Services\QuestionsService;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    /**
     * Injecting the Service to handle the business logic
     */
    public function __construct(
        private AnswersService $answersService,
        private QuestionsService $questionsService,
    ) {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $quiz, int $question)
    {
        return view('answers.create', [
            'quiz_id' => $quiz,
            'question_id' => $question,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $quiz, int $question)
    {
        $request->request->add(['question_id' => $question]);
        $request->request->add(['is_correct' => $request->has('is_correct') ? true : false]);

        $answer = $this->answersService->save($request);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question,
            'answer' => $answer->id,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $quiz, int $question, int $answer)
    {
        $answer = $this->answersService->get($answer);

        if (! $answer->canBeEditedBy()) {
            return redirect()->back();
        }

        return view('answers.edit', [
            'quiz_id' => $quiz,
            'question_id' => $question,
            'answer' => $answer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $quiz, int $question, int $answer)
    {
        $request->request->add(['question_id' => $question]);
        $request->request->add(['is_correct' => $request->has('is_correct') ? true : false]);

        $answer = $this->answersService->save($request, $answer);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question,
        ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $quiz, int $question, int $answer)
    {
        $this->answersService->delete($answer);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question,
        ]));
    }
}
