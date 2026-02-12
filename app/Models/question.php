<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'question',
        'quiz_id',
        'subtopic_id',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'correct_answer'

    ];
    public function quiz()
    {
        return $this->belongsTo(quiz::class);
    }
    public function subtopic()
    {
        return $this->belongsTo(subtopic::class);
    }
    public function answers()
    {
        return $this->hasMany(answer::class);
    }

}
