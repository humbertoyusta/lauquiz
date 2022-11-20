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
    
    public function paginateFromQuizWithPerfAndUser (int $quiz_id, int $perPage) 
    {
        return AnsweredQuiz
            ::where('quiz_id', $quiz_id)
            ->with(['user'])
            ->withCount('answeredQuestions', 'correctAnsweredQuestions')
            ->orderByDesc('correct_answered_questions_count')
            ->paginate($perPage);
    }
}