<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function units()
    {
        return $this->hasMany(unit::class);
    }
    
}
