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
    public function create(Request $request)
    {
        return view('questions.create', ['quiz_id' => $request->get('quiz_id')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = $this->questionsService->save($request);

        return view('questions.edit', [
            'question' => $this->questionsService->getQuestionWithAnswers($question->id),
        ]);
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
    public function edit(int $id)
    {
        return view('questions.edit', [
            'question' => $this->questionsService->getQuestionWithAnswers($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $dto = $request->validate(['content' => 'required']);

        $dto['id'] = $id;

        $this->questionsService->save($request, $id);

        return view('questions.edit', ['question' => $this->questionsService->getQuestionWithAnswers($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $question = $this->questionsService->get($id);

        $quiz = $this->quizzesService->getQuizwithQuestions($question->quiz_id);

        $this->questionsService->delete($id);

        return redirect(route('quizzes.edit', [
            'quiz' => $quiz,
            'alertMessage' => 'Deleted succesfully',
        ]));
    }
}
