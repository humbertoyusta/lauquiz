<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyQuizController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\QuizzesController;
use App\Http\Controllers\Api\v1\QuestionsController;
use App\Http\Controllers\Api\v1\AnswersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware(['auth:sanctum', 'ability:quizzes-edit'])->group(function () {

        Route::apiResource('quizzes', QuizzesController::class, ['as' => 'api'])->name('*', 'api.quizzes');

        Route::prefix('quizzes/{quiz}')->group(function () {

            Route::apiResource('questions', QuestionsController::class, ['as' => 'api'])->name('*', 'api.questions');

            Route::prefix('questions/{question}')->group(function () {

                Route::apiResource('answers', AnswersController::class, ['as' => 'api'])->name('*', 'api.answers');
            });
        });
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('mollie')->group(function () {
    Route::post('webhook', [BuyQuizController::class, 'webhook'])->name('mollie.webhook');
});
