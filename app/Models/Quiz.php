<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author_id',
        'correct_answer_id',
    ];

    // Quiz Relations
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function answeredQuizzes()
    {
        return $this->hasMany(AnsweredQuiz::class);
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class)
            ->withTimestamps();
    }

    // Quiz custom functions

    /**
     * Checks whether the quiz can be edited by a given user or the logged in user if no user is given
     */
    public function canBeEditedBy(int $id = null): bool
    {
        // Get the given user, if no user is given take the logged in user
        $user = ($id !== null) ? User::findOrFail($id) : Auth::user();

        // Admins or owners can edit
        return ($user->is_admin || $user->id === $this->author_id);
    }

    // Quiz Events
    protected $dispatchesEvents = [
        'saving' => QuizCheckIsADraftEvent::class,
    ];

    protected static function booted()
    {
        static::saved(function ($quiz) {
            // Delete quizzes cache after modifying a Quiz
            Cache::forget('play.index.allquizzes');
        });
        static::deleted(function ($quiz) {
            // Delete quizzes cache after modifying a Quiz
            Cache::forget('play.index.allquizzes');
        });
        static::deleting(function($quiz) {
            /**
             * Cascade Deletes
             * Not using mass delete to make sure deleting and deleted events of children are thrown
             */
            foreach ($quiz->questions as $question)
                $question->delete();
            foreach ($quiz->answeredQuizzes as $answeredQuiz)
                $answeredQuiz->delete();
        });
    }
}
