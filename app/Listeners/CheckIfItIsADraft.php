<?php

namespace App\Listeners;

use App\Events\QuizCheckIsADraftEvent;
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
     * Checks if a Quiz is a draft,
     * updates is_draft field of Quiz
     *
     * @param  \App\Events\QuizSavingEvent  $event
     * @return void
     */
    public function handle(QuizCheckIsADraftEvent $event)
    {
        $quiz = $event->quiz;

        $quiz->is_draft = $this->isADraft($quiz);
    }

    /**
     * Actually check if a quiz is a draft
     * @return boolean true if it is a draft, false if it playable
     */
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
