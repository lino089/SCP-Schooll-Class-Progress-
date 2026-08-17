<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'student_id',
        'reason',
        'start_date',
        'end_date',
        'proof_image',
        'status',
        'rejection_reason'
    ];

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
}
