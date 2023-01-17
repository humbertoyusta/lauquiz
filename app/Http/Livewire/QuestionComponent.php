<?php

namespace App\Http\Livewire;

use App\Models\Question;
use Livewire\Component;

class QuestionComponent extends Component
{
    public Question $question;

    public string $content;

    public string $image;

    public function mount(Question $question, $image) {
        
        $this->question = $question;

        $this->content = $question->content;

        $this->image = $image;
    }

    public function render()
    {
        if (!$this->question->canBeEditedBy())
            abort(403);

        $this->question->update([
            'content' => $this->content,
        ]);

        return view('livewire.question-component');
    }
}
