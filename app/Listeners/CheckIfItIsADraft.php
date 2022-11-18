<?php

namespace App\Listeners;

use App\Events\QuizSavingEvent;
use App\Models\Quiz;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckIfItIsADraft
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\QuizSavingEvent  $event
     * @return void
     */
    public function handle(QuizSavingEvent $event)
    {
        $quiz = $event->quiz->load(['questions' => ['correctAnswers']]);

        $quiz->is_draft = $this->isADraft($quiz);
    }

    private function isADraft(Quiz $quiz): bool 
    {
        $quiz->load(['questions' => ['correctAnswers']]);

        if (count($quiz->questions) === 0)
            return true;
        
        foreach ($quiz->questions as $question)
            if (count($question->correctAnswers) === 0)
                return true;

        return false;
    }
}
