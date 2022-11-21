<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Question extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quiz_id',
        'content',
    ];

    // Question Relations
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }
    
    public function correctAnswers()
    {
        return $this->hasMany(Answer::class)->where('is_correct', 1);
    }
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Question custom functions

    /**
     * Checks whether the question can be edited by a given user or the logged in user if no user is given
     */
    public function canBeEditedBy(int $id = null): bool
    {
        // Get the given user, if no user is given take the logged in user
        $user = ($id !== null) ? User::findOrFail($id) : Auth::user();

        // Admins or owners can edit
        return ($user->is_admin || $user->id == $this->quiz->author_id);
    }

    // Question Media Conversions
    public function registerMediaCollections(Media $media = null): void
    {   
        $this
            ->addMediaConversion('display')
            ->fit(Manipulations::FIT_CROP, 512, 512)
            ->nonQueued();
    }

    // Question Events
    protected static function booted()
    {
        // Update quiz when updating question to allow QuizCheckIsADraftEvent event being thrown
        static::saved(fn($question) => $question->quiz->update([]));
        static::deleted(fn($question) => $question->quiz->update([]));
    }
}
