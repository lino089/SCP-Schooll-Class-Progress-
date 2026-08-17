<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable =[
        'teacher_id', 
        'class_id', 
        'room_id', 
        'day_of_week', 
        'start_time', 
        'end_time', 
        'cycle_type'
    ];

    public function schoolClass(){
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
