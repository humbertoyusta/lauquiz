<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Route;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Answer $answer)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $quiz = Route::input('quiz');

        return ($user->is_admin || ($user->id === $quiz->author_id));
    }

    public function update(User $user, Answer $answer)
    {
        return ($user->is_admin || ($user->id === $answer->question->quiz->author_id));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Answer $answer)
    {
        return ($user->is_admin || ($user->id === $answer->question->quiz->author_id));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Answer $answer)
    {
        return ($user->is_admin || ($user->id === $answer->question->quiz->author_id));
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Answer $answer)
    {
        return $user->is_admin;
    }
}
