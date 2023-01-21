<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class BuyQuizController extends Controller
{
    public function show(Quiz $quiz) {
        $user = auth()->user();

        return $user->checkoutCharge(
            config('app.quizzes.default_price'),
            'Quiz '.$quiz->title,
            1,
            [
                'success_url' => route('play.index'),
                'cancel_url' => route('play.index'),
                'metadata' => [
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                ],
            ],
        );
    }
}
