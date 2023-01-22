<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyQuizController;

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
    Route::apiResource('quizzes', \App\Http\Controllers\Api\v1\QuizzesController::class)->name('*', 'api.quizzes');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('mollie')->group(function () {
    Route::post('webhook', [BuyQuizController::class, 'webhook'])->name('mollie.webhook');
});
