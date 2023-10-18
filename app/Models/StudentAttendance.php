<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAttendance extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'classroom_session_id',
        'student_id',
        'status',
    ];

    public function classroomSession()
    {
        return $this->belongsTo(ClassroomSession::class, 'classroom_session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
