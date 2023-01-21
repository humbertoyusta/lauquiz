<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Notifications\SuccessfulQuizPurshaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class BuyQuizController extends Controller
{
    public function show(Quiz $quiz) {
        $payment = Mollie::api()->payments()->create([
            "amount" => [
                "currency" => "EUR",
                "value" => ''.intdiv(config('app.quizzes.default_price'), 100).'.'.(config('app.quizzes.default_price') % 100), // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Buy Quiz ".$quiz->title,
            "redirectUrl" => route('play.index'),
            "webhookUrl" => route('mollie.webhook'),
            "metadata" => [
                "user_id" => auth()->user()->id,
                "quiz_id" => $quiz->id,
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhook (Request $request)
    {
        $payment = Mollie::api()->payments->get($request->input('id'));

        $user = User::find($payment->metadata->user_id);
        $quiz = Quiz::find($payment->metadata->quiz_id);

        if ($payment->status == 'paid') {
            $quiz->owner()->associate($user);
            $quiz->save();

            $user->notify(new SuccessfulQuizPurshaseNotification($quiz));
        }
    }
}
