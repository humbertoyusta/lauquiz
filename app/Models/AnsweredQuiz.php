<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnsweredQuiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'quiz_id',
    ];

    // AnsweredQuiz Relations
    public function answeredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class);
    }

    public function correctAnsweredQuestions()
    {
        return $this->hasMany(AnsweredQuestion::class)->where('is_correct', 1);
    }

    public function quiz () {
        return $this->belongsTo(Quiz::class);
    }
    
    public function user () {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($answeredQuiz) {
            // Cascade Deletes
            $answeredQuiz->answeredQuestions()->delete();
        });
    }
}
