<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiQuiz extends Model
{
    protected $fillable = [
        'teacher_id',
        'class_id',
        'topic',
        'questions_data'
    ];
}
