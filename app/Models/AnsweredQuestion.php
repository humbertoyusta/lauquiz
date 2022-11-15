<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
