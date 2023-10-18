<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['admission_year', 'date_of_birth', 'last_education_year'];

    protected $fillable = [
        'user_id',
        'major_id',
        'current_credits',
        'admission_year',
        'date_of_birth',
        'gender',
        'status',
        'address',
        'phone_number',
        'guardian_name',
        'guardian_phone_number',
        'blood_type',
        'tuition_fee',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classrooms_students', 'student_id', 'classroom_id');
    }

    public function enrollments() 
    {
        return $this->hasMany(ClassroomEnrollment::class, 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'student_id');
    }

    public function seasonLogs()
    {
        return $this->hasMany(StudentSeasonLog::class, 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'student_id');
    }

    public function tuitionPayments()
    {
        return $this->hasMany(TuitionPayment::class, 'student_id');
    }

    public function advisors()
    {
        return $this->belongsToMany(Lecturer::class, 'academic_advisors', 'student_id', 'lecturer_id');
    }
}
