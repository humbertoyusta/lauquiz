<?php

namespace App\Models;

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
        'owner_id',
        'correct_answer_id',
        'is_draft',
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

    public function owner ()
    {
        return $this->belongsTo(User::class, 'owner_id');
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
        return $user->is_admin || $user->id === $this->author_id;
    }

    public function syncTags(string $tagNamesCommaSeparated): void
    {
        $tagNames = collect(explode(',', $tagNamesCommaSeparated))->map(fn ($k) => ucfirst(strtolower(trim($k))));

        foreach ($tagNames as $tagName) {
            $tagIds[] = Tag::firstOrCreate([
                'name' => $tagName,
            ])->id;
        }

        $this->tags()->sync($tagIds);
    }

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
        static::deleting(function ($quiz) {
            /**
             * Cascade Deletes
             * Not using mass delete to make sure deleting and deleted events of children are thrown
             */
            foreach ($quiz->questions as $question) {
                $question->delete();
            }
            foreach ($quiz->answeredQuizzes as $answeredQuiz) {
                $answeredQuiz->delete();
            }
        });
    }
}
