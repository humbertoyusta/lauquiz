<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswers()
    {
        return $this->hasMany(Answer::class)->where('is_correct', 1);
    }

    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }

    public function registerMediaCollections(Media $media = null): void
    {   
        $this
            ->addMediaConversion('display')
            ->fit(Manipulations::FIT_CROP, 512, 512)
            ->nonQueued();
    }

    protected static function booted()
    {
        static::saved(fn($question) => $question->quiz->update([]));
        static::deleted(fn($question) => $question->quiz->update([]));
    }
}
