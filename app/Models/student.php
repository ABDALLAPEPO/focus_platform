<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function answers()
    {
        return $this->hasMany(answer::class);
    }
    public function quizzesAttempt()
    {
        return $this->hasMany(quizAttempt::class);
    }

}
