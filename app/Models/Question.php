<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quiz_id',
        'content',
    ];

    public function quiz ()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class);
    }
}
