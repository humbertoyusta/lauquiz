<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AnsweredQuestion extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'answered_quiz_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    // AnsweredQuestion Relations
    public function answer ()
    {
        return $this->belongsTo(Answer::class);
    }

    public function answeredQuiz ()
    {
        return $this->belongsTo(AnsweredQuiz::class);
    }

    public function question ()
    {
        return $this->belongsTo(Question::class);
    }

    // AnsweredQuestion Events
    protected static function booted()
    {
        // Create an Answered Quiz for Answered Question being created if there is not one
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
