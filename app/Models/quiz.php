<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'teacher_id',
        'video_id',
    ];

    public function lesson(){
        return $this->belongsTo(lesson::class);
    }
    public function teacher(){
        return $this->belongsTo(teacher::class);
    }
    public function video(){
        return $this->belongsTo(video::class);
    }
    public function questions(){
        return $this->hasMany(question::class);
    }
    public function answers(){
        return $this->hasMany(answer::class);
    }
    public function quizzesAttempt(){
        return $this->hasMany(quizAttempt::class);
    }
}
