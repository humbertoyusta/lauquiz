<?php

namespace App\Services;

use App\Models\AnsweredQuestion;

class AnsweredQuizzesService
{
    public function performance (int $answeredQuizId)
    {
        $correctAnswersCount = AnsweredQuestion::where('answered_quiz_id', $answeredQuizId)
            ->with(['answer'])
            ->whereHas('answer', fn($answer) => $answer->where('is_correct', 1) )
            ->count();

        $answersCount = AnsweredQuestion::where('answered_quiz_id', $answeredQuizId)->count();

        return [
            'correct_answers_count' => $correctAnswersCount,
            'answers_count' => $answersCount,
        ];
    }
}