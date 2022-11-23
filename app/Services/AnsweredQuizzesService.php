<?php

namespace App\Services;

use App\Models\AnsweredQuiz;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnsweredQuizzesService
{
    /**
     * Get AnsweredQuiz given id
     * With answered_questions_count and correct_answered_questions_count loaded
     */
    public function getWithPerf(int $answeredQuizId)
    {
        return AnsweredQuiz::where('id', $answeredQuizId)
            ->withCount('answeredQuestions', 'correctAnsweredQuestions')
            ->sole();
    }

    /**
     * Get AnsweredQuizzes paginated with user,
     * answered_questions_count and correct_answered_questions_count loaded,
     * Sorted in descending order
     */
    public function paginateFromQuizWithPerfAndUser(int $quiz_id, int $perPage)
    {
        return AnsweredQuiz::where('quiz_id', $quiz_id)
            ->with(['user'])
            ->withCount('answeredQuestions', 'correctAnsweredQuestions')
            ->orderByDesc('correct_answered_questions_count')
            ->paginate($perPage);
    }

    public function getMaxAnsweredQuizIdFromAuthUser()
    {
        return AnsweredQuiz::where('user_id', Auth::user()->id)->max('id');
    }
}
