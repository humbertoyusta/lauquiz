<?php

namespace App\Http\Livewire;

use App\Models\Question;
use Livewire\Component;

class QuestionComponent extends Component
{
    public Question $question;

    public string $content;

    public string $image;

    protected $listeners = ['AnswerDeletedEvent' => 'handleAnswerDeleted'];

    public function handleAnswerDeleted ()
    {
        $this->question->refresh();
    }

    public function mount(Question $question, $image) {

        $this->question = $question;

        $this->content = $question->content;

        $this->image = $image;
    }

    public function update ()
    {
        $this->question->update([
            'content' => $this->content,
        ]);
    }

    public function render()
    {
        if (!$this->question->canBeEditedBy())
            abort(403);

        return view('livewire.question-component');
    }
}
