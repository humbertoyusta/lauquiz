<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnswersService;
use App\Services\QuestionsService;

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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function create (Request $request)
    {
        return view('answers.create', ['question_id' => $request->get('question_id')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $answer = $this->answersService->save($request);

        $question = $this->questionsService->getQuestionWithAnswers($answer->question_id);

        return redirect(route('questions.edit', ['question' => $question]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('answers.edit', [
            'answer' => $this->answersService->get($id),
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
        $answer = $this->answersService->save($request, $id);

        $question = $this->questionsService->getQuestionWithAnswers($answer->question_id);

        return redirect(route('questions.edit', ['question' => $question]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $answer = $this->answersService->get($id);

        $this->answersService->delete($id);
        
        $question = $this->questionsService->getQuestionWithAnswers($answer->question_id);

        return redirect(route('questions.edit', [
            'question' => $question,
            'alertMessage' => 'Deleted succesfully',
        ])); 
    }
}
