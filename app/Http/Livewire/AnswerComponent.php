<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use Livewire\Component;

class AnswerComponent extends Component
{
    public string $content;

    public bool $is_correct;

    public Answer $answer;

    public function mount (Answer $answer)
    {
        $this->answer = $answer;

        $this->content = $answer->content;

        $this->is_correct = $answer->is_correct;
    }

    public function deleteAnswer ()
    {
        $this->answer->delete();
    }

    public function render()
    {
        if (!$this->answer->canBeEditedBy())
            abort(403);

        $this->answer->update([
            'content' => $this->content,
            'is_correct' => $this->is_correct,
        ]);

        return view('livewire.answer-component');
    }
}
