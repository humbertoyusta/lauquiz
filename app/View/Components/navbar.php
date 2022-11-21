<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
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
                'title' => 'Play',
                'url' => '/play',
            ],
        ];

        if (Auth::user() && Auth::user()->is_admin)
            $this->navbarItems[] = ['title' => 'users', 'url' => route('users.index')];
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
