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
    public function create (int $quiz, int $question)
    {
        return view('answers.create', [
            'quiz_id' => $quiz,
            'question_id' => $question,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $quiz, int $question)
    {
        $request->request->add(['question_id' => $question]);

        $answer = $this->answersService->save($request);

        return redirect(route('questions.edit', [
            'quiz' => $quiz, 
            'question' => $question,
            'answer' => $answer->id,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $quiz, int $question, int $answer)
    {
        return view('answers.edit', [
            'quiz_id' => $quiz,
            'question_id' => $question,
            'answer' => $this->answersService->get($answer),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $quiz, int $question, int $answer)
    {
        $request->request->add(['question_id' => $question]);

        $answer = $this->answersService->save($request, $answer);

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
    public function destroy(int $quiz, int $question, int $answer)
    {
        $this->answersService->delete($answer);

        return redirect(route('questions.edit', [
            'quiz' => $quiz,
            'question' => $question,
            'alertMessage' => 'Deleted succesfully',
        ])); 
    }
}
