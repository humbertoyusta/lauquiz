<?php

namespace App\Services;

use App\Models\AnsweredQuestion;
use App\Models\AnsweredQuiz;

class AnsweredQuizzesService
{
    public function getWithPerf (int $answeredQuizId)
    {
        return AnsweredQuiz
            ::where('id', $answeredQuizId)
            ->withCount('answeredQuestions', 'correctAnsweredQuestions')
            ->sole();
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