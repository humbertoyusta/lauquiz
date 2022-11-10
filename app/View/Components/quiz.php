<?php

namespace App\View\Components;

use App\Models\Quiz as QuizModel;
use Illuminate\View\Component;

class quiz extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public QuizModel $quiz,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.quiz', ['quiz' => $this->quiz]);
    }
}
