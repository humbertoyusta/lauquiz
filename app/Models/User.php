<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\RegisterNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User Relations
    public function answeredQuizzes()
    {
        return $this->hasMany(AnsweredQuiz::class);
    }
    
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'author_id');
    }

    // User Events
    protected static function booted()
    {
        static::created( fn($user) => $user->notify(new RegisterNotification) );
        static::deleting(function ($user): bool {
            // If user has quizzes that are not deleted, do not delete the user
            if ($user->quizzes->count() !== 0)
                return false;
            return true;
        });
    }
}
