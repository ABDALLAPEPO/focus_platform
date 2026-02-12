<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quizAttempt extends Model
{
    /** @use HasFactory<\Database\Factories\QuizAttemptFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'quiz_id',
        'score'
    ];

    public function student(){
        return $this->belongsTo(student::class);
    }
    public function quiz(){
        return $this->belongsTo(quiz::class);
    }
}
