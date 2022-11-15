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
}
