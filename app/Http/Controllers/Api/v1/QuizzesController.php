<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizRequest;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizzesController extends Controller
{
    public function __construct ()
    {
        $this->authorizeResource(Quiz::class, 'quiz');
    }

    public function index()
    {
        return QuizResource::collection(Quiz::all());
    }

    public function store(QuizRequest $request)
    {
        $quiz = Quiz::create($request->validated());

        return QuizResource::make($quiz);
    }

    public function show(Quiz $quiz)
    {
        return QuizResource::make($quiz);
    }

    public function update(QuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->validated());

        return QuizResource::make($quiz);
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return QuizResource::make($quiz);
    }
}
