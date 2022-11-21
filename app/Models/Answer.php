<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Answer Events
    protected static function booted()
    {
        // Update quiz when updating answer to allow QuizCheckIsADraftEvent event being thrown
        static::saved(fn($answer) => $answer->question->quiz->update([]));
        static::deleted(fn($answer) => $answer->question->quiz->update([]));
    }
}
