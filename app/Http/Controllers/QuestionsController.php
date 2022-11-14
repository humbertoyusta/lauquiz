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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $quiz)
    {
        return view('questions.create', [
            'quiz_id' => $quiz,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $quiz, int $question)
    {
        return view('questions.edit', [
            'quiz_id' => $quiz,
            'question' => $this->questionsService->getQuestionWithAnswers($question),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $quiz, int $question)
    {
        $this->questionsService->delete($question);

        return redirect(route('quizzes.edit', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($quiz),
            'alertMessage' => 'Deleted succesfully',
        ]));
    }
}
