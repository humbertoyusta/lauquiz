<?php

namespace App\Http\Livewire;

use App\Models\Quiz;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QuizParentComponent extends Component
{
    public Quiz $quiz;

    public string $title;

    public string $tags;

    public function mount (Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->title = $quiz->title;
        $this->tags = implode(', ', $quiz->tags->pluck('name')->toArray());
    }

    public function update ()
    {
        try {
            DB::beginTransaction();

            $this->quiz->update([
                'title' => $this->title,
            ]);

            $this->quiz->syncTags($this->tags);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        $this->quiz->refresh();

        $this->tags = implode(', ', $this->quiz->tags->pluck('name')->toArray());
    }

    protected $listeners = ['QuestionDeletedEvent' => 'handleQuestionDeleted'];

    public function handleQuestionDeleted ()
    {
        $this->quiz->refresh();
    }

    public function render()
    {
        return view('livewire.quiz-parent-component');
    }
}
