<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    /** @use HasFactory<\Database\Factories\QuizAttemptFactory> */
    use HasFactory;
    protected $fillable = [
        'student_id',
        'quiz_id',
        'score'
    ];

    protected static function booted()
    {
        static::saved(function ($attempt) {
            if ($attempt->wasChanged('student_id')) {
                cache()->forget('quiz_attempts_student_' . $attempt->getOriginal('student_id') . '_all');
            }
            cache()->forget('quiz_attempts_student_' . $attempt->student_id . '_all');
        });
        static::deleted(fn($attempt) => cache()->forget('quiz_attempts_student_' . $attempt->student_id . '_all'));
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
