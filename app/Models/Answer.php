<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'content',
        'is_correct',
    ];

    // Answer Relations
    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Answer custom functions

    /**
     * Checks whether the answer can be edited by a given user or the logged in user if no user is given
     */
    public function canBeEditedBy(int $id = null): bool
    {
        // Get the given user, if no user is given take the logged in user
        $user = ($id !== null) ? User::findOrFail($id) : Auth::user();

        // Admins or owners can edit
        return ($user->is_admin || $user->id == $this->question->quiz->author_id);
    }

    // Answer Events
    protected static function booted()
    {
        // Update quiz when updating answer to allow QuizCheckIsADraftEvent event being thrown
        static::saved(fn($answer) => $answer->question->quiz->update([]));
        static::deleted(fn($answer) => $answer->question->quiz->update([]));
    }
}
