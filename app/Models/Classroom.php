<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'capacity',
        'credits',
        'season_id',
        'course_id',
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classroomSessions()
    {
        return $this->hasMany(ClassroomSession::class);
    }

    public function classroomEnrollments()
    {
        return $this->hasMany(ClassroomEnrollment::class, 'classroom_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
        // return $this->belongsToMany(Student::class, 'classroom_enrollments', 'classroom_id', 'student_id')
        //     ->withPivot('status', 'remarks');
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'classroom_lecturer', 'classroom_id', 'lecturer_id');
    }
}
