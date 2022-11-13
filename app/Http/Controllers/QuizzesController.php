<?php

namespace App\Http\Controllers;

use App\Services\QuizzesService;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    /**
     * Injecting the Service to handle the business logic
     */
    public function __construct(
        private QuizzesService $quizzesService,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('quizzes.index', [
            'quizzes' => $this->quizzesService->get(),
            'alertMessage' => $request->query('alertMessage'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = $request->validate(['title' => 'required|max:255']);

        $quiz = $this->quizzesService->save($dto);

        return view('quizzes.edit', ['quiz' => $quiz]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('quizzes.show', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('quizzes.edit', [
            'quiz' => $this->quizzesService->getQuizwithQuestions($id),
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
        $dto = $request->validate(['title' => 'required|max:255']);

        $dto['id'] = $id;

        $this->quizzesService->save($dto);

        return view('quizzes.edit', ['quiz' => $this->quizzesService->getQuizwithQuestions($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->quizzesService->delete($id);

        return redirect(route('quizzes.index', ['alertMessage' => 'Deleted succesfully']));
    }
}
