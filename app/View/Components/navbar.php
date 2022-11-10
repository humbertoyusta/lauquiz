<?php

namespace App\View\Components;

use Illuminate\View\Component;

class navbar extends Component
{
    public array $navbarItems = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->navbarItems = [
            [
                'title' => 'Welcome',
                'url' => route('welcome'),
            ],
            [
                'title' => 'Quizzes',
                'url' => route('quizzes.index'),
            ],
            [
                'title' => 'Create new quiz',
                'url' => route('quizzes.create'),
            ],
            [
                'title' => 'Play',
                'url' => '/play',
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar');
    }
}
