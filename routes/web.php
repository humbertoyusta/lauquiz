<?php

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

Route::get('/', WelcomeController::class)->name('welcome');

Route::middleware(['auth'])->group(function () {
    
    Route::resource('quizzes', QuizzesController::class);
    
    Route::prefix('quizzes/{quiz}')->group(function () {
        Route::resource('questions', QuestionsController::class)->except(['index']);
    
        Route::prefix('questions/{question}')->group( function () {
            Route::resource('answers', AnswersController::class)->except(['index', 'show']);
        });
    });
    
    Route::get('play', [PlayQuizController::class, 'index'])->name('play.index');
    Route::get('play/{quiz}', [PlayQuizController::class, 'show'])->name('play.show');
    
    Route::get('play/{quiz}/questions/{question}/{answered_quiz?}', [PlayQuizController::class, 'questionsShow'])->name('play.questions.show');
    Route::post('play/{quiz}/questions/{question}/{answered_quiz?}', [PlayQuizController::class, 'questionsStore'])->name('play.questions.store');
    
    Route::middleware(['admin'])->resource('users', UsersController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
