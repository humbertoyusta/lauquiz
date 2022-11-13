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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = $request->validate([
            'content' => 'required',
            'question_id' => 'required|min:1|integer',
        ]);

        $answer = $this->answersService->save($dto);

        $question = $this->questionsService->getQuestionWithAnswers($answer->question_id);

        return redirect(route('questions.edit', ['question' => $question]));
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
        $dto = $request->validate([
            'content' => 'required',
            'question_id' => 'required',
        ]);

        $dto['id'] = $id;

        $answer = $this->answersService->save($dto);

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
