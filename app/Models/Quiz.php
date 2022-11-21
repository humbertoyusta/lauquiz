<?php

namespace App\Models;

use App\Events\QuizCheckIsADraftEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Tag::class);
    }

    // Quiz Events
    protected $dispatchesEvents = [
        'saving' => QuizCheckIsADraftEvent::class,
    ];
}
