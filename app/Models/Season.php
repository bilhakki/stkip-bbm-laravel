<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function classroomEnrollments()
    {
        return $this->hasMany(ClassroomEnrollment::class);
    }

    public function classroomSessions()
    {
        return $this->hasMany(ClassroomSession::class);
    }

    public function studentSeasonLogs()
    {
        return $this->hasMany(StudentSeasonLog::class);
    }

    public function studentGrades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function tuitionPayments()
    {
        return $this->hasMany(TuitionPayment::class);
    }
}
