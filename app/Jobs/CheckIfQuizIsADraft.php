<?php

namespace App\Jobs;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckIfQuizIsADraft implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Quiz $quiz;

    /**
     * Create a new job instance.
     * Store the quiz.
     *
     * @return void
     */
    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * Execute the job.
     * Checks if Quiz is a draft or not and update that.
     *
     * @return void
     */
    public function handle()
    {
        // Loading the questions with the count of correct answers
        $this->quiz->load(['questions' => (fn ($query) => $query->withCount('correctAnswers'))]);

        $isDraft = false;

        // If a quiz does not have any questions, it is a draft
        if (count($this->quiz->questions) === 0) {
            $isDraft = true;
        }

        // If some question has no correct answers, it is also a draft
        if ($this->quiz->questions->pluck('correct_answers_questions')->search(0) === false) {
            $isDraft = true;
        }

        $this->quiz->update(['is_draft' => $isDraft]);
    }
}
