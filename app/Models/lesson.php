<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;
    protected $fillable = [
        'unit_id',
        'title',
       
    ];
    public function unit()
    {
        return $this->belongsTo(unit::class);      } 
    public function subtopics()
    {
        return $this->hasMany(subtopic::class); }

    public function quizzes(){
        return $this->hasMany(quiz::class);
    }
}
