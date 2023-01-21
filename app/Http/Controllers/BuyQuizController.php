<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class BuyQuizController extends Controller
{
    public function show(Quiz $quiz) {
        $user = auth()->user();
    }
}
