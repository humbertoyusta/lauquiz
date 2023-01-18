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

    public function delete ()
    {
        $this->answer->delete();

        $this->emit('AnswerDeletedEvent');
    }

    public function update ()
    {
        $this->answer->update([
            'content' => $this->content,
            'is_correct' => $this->is_correct,
        ]);
    }

    public function render()
    {
        return view('livewire.answer-component');
    }
}
