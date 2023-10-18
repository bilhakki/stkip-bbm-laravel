<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'major_id',
        'faculty_id',
        'code',
        'name',
        'credits',
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisites', 'course_id', 'prerequisite_course_id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'course_id');
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class, 'course_id');
    }
}
