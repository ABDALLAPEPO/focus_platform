<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;
    protected $fillable = [
        'subject_id',
        'title',
       
    ];
    public function subject()
    {
        return $this->belongsTo(subject::class);
    }
    public function lessons()
    {
        return $this->hasMany(lesson::class);
    }
    public function subtopics()
    {
        return $this->hasManyThrough(subtopic::class, lesson::class);
    }
}
