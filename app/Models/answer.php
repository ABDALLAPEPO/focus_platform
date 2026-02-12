<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;
    protected $fillable = [
        'quiz_id',
        'question_id',
        'student_id',
        'answer_text',
        'correctness'
    ];
    
    public function quiz(){
    //    quiz::distinct()->
        return $this->belongsTo(quiz::class);
        }
    public function question(){
        return $this->belongsTo(question::class);
        }
    public function student(){
        return $this->belongsTo(student::class);
        }

}
