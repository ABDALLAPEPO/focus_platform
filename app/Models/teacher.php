<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);   }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function quizzes()
    {
        return $this->hasMany(quiz::class);
    }
    public function videos()
    {
        return $this->hasMany(video::class);
    }
    
}
