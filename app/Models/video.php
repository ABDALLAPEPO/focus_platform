<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'lesson_id',
        'title',
        'url',
    ];
    public function lesson()
    {
        return $this->belongsTo(lesson::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function quizzes()
    {
        return $this->hasMany(quiz::class);
    }

}
