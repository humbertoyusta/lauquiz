<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AnsweredQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'answered_quiz_id',
        'question_id',
        'answer_id',
    ];

    public function answeredQuiz ()
    {
        return $this->belongsTo(AnsweredQuiz::class);
    }

    public function question ()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer ()
    {
        return $this->belongsTo(Answer::class);
    }

    protected static function booted()
    {
        static::creating(
            function ($answeredQuestion) {
                if (!$answeredQuestion->answered_quiz_id) {
                    $answeredQuestion->answered_quiz_id = AnsweredQuiz::create([
                        'quiz_id' => $answeredQuestion->question->quiz_id,
                        'user_id' => Auth::user()->id,
                    ])->id;
                }
            }
        );
    }
}
