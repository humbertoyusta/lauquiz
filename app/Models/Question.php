<?php

namespace App\Models;

use App\Jobs\CheckIfQuizIsADraft;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Question extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

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
        return $user->is_admin || $user->id == $this->quiz->author_id;
    }

    public function storeImage ($image)
    {
        $this->clearMediaCollection();

        $this
            ->addMedia($image)
            ->usingFileName($image->hashName())
            ->toMediaCollection();
    }

    public function getImage ()
    {
        if ($this->getMedia()->first()) {
            return $this->media->first()->getUrl('display');
        } else {
            return '/images/question-mark.png';
        }
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
        static::saved(function ($question) {
            // Dispatching CheckIfQuizIsADraft event
            CheckIfQuizIsADraft::dispatch($question->quiz);
        });
        static::deleted(function ($question) {
            // Dispatching CheckIfQuizIsADraft event
            CheckIfQuizIsADraft::dispatch($question->quiz);
        });
        static::deleting(function ($question) {
            // Cascade Deletes
            $question->answers()->delete();
        });
    }
}
