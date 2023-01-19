<?php

namespace App\Http\Livewire;

use App\Models\Question;
use Livewire\Component;

class QuestionChildComponent extends Component
{
    public Question $question;

    public function delete ()
    {
        $this->question->delete();

        $this->emit('QuestionDeletedEvent');
    }

    public function render()
    {
        return view('livewire.question-child-component');
    }
}
