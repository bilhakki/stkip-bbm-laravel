<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentGrade extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grade',
        'student_id',
        'course_id',
        'classroom_id',
        'season_id',
        'user_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
