<?php

use App\Http\Controllers\AnsweredQuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\PlayQuizController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\QuizzesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', WelcomeController::class)->name('welcome');

// Logged In Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('quizzes', QuizzesController::class);

    Route::prefix('quizzes/{quiz}')->group(function () {
        // Displays scoreboard of a quiz
        Route::get('scoreboard', [QuizzesController::class, 'scoreboard'])->name('quizzes.scoreboard');

        Route::resource('questions', QuestionsController::class)->except(['index']);

        Route::prefix('questions/{question}')->group(function () {
            Route::resource('answers', AnswersController::class)->except(['index', 'show']);
        });
    });

    // Index of all playable quizzes
    Route::get('play', [PlayQuizController::class, 'index'])->name('play.index');

    // Shows performance of a played quiz
    Route::get('play/{quiz}/{answered_quiz}', [PlayQuizController::class, 'show'])->name('play.show');

    // Shows the page to answer a question
    Route::get('play/{quiz}/questions/{question}/{answered_quiz?}', [AnsweredQuestionsController::class, 'show'])->name('play.questions.show');

    // Store an answered question
    Route::post('play/{quiz}/questions/{question}/{answered_quiz?}', [AnsweredQuestionsController::class, 'store'])->name('play.questions.store');

    // Admin Routes
    Route::middleware(['admin'])->resource('users', UsersController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
