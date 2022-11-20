<?php

namespace App\Services;

use App\Models\AnsweredQuestion;
use App\Models\AnsweredQuiz;

class AnsweredQuizzesService
{
    public function performance (AnsweredQuiz $answeredQuiz)
    {
        return collect([
            'correct_answers_count' => $answeredQuiz->correctAnsweredQuestions()->count(),
            'answers_count' => $answeredQuiz->answeredQuestions()->count(),
        ]);
    }

    public function getPerformanceFromId (int $id)
    {
        return $this->performance(AnsweredQuiz::findOrFail($id));
    }
    
}