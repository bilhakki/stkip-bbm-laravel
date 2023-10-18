<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecturer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'position',
        'specialization',
        'phone_number',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classrooms_lecturers', 'lecturer_id', 'classroom_id');
    }

    public function classroomSessions()
    {
        return $this->hasMany(ClassroomSession::class, 'lecturer_id');
    }

    public function advisees()
    {
        return $this->belongsToMany(Student::class, 'academic_advisors', 'lecturer_id', 'student_id');
    }
}