<?php

namespace App\Http\Livewire;

use App\Models\Question;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuestionParentComponent extends Component
{
    use WithFileUploads;

    public Question $question;

    public string $content;

    public $image;

    protected $listeners = ['AnswerDeletedEvent' => 'handleAnswerDeleted'];

    public function handleAnswerDeleted ()
    {
        $this->question->refresh();
    }

    public function mount(Question $question) {

        $this->question = $question;

        $this->content = $question->content;
    }

    public function update ()
    {
        if (!$this->question->canBeEditedBy())
            abort(403);

        $this->question->update([
            'content' => $this->content,
        ]);

        if ($this->image) {
            $this->question->storeImage($this->image);
        }

        $this->question->refresh();
    }

    public function render()
    {
        return view('livewire.question-parent-component');
    }
}
