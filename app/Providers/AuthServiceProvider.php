<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Classroom;
use App\Models\ClassroomSession;
use App\Models\Course;
use App\Models\CoursePrerequisite;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\Room;
use App\Models\Season;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentGrade;
use App\Models\StudentSeasonLog;
use App\Models\TuitionPayment;
use App\Policies\ClassroomEnrollmentPolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\ClassroomSessionPolicy;
use App\Policies\CoursePolicy;
use App\Policies\CoursePrerequisitePolicy;
use App\Policies\FacultyPolicy;
use App\Policies\LecturerPolicy;
use App\Policies\MajorPolicy;
use App\Policies\RoomPolicy;
use App\Policies\SeasonPolicy;
use App\Policies\StudentAttendancePolicy;
use App\Policies\StudentGradePolicy;
use App\Policies\StudentPolicy;
use App\Policies\StudentSeasonLogPolicy;
use App\Policies\TuitionPaymentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ClassroomEnrollment::class => ClassroomEnrollmentPolicy::class,
        Classroom::class => ClassroomPolicy::class,
        ClassroomSession::class => ClassroomSessionPolicy::class,
        Course::class => CoursePolicy::class,
        CoursePrerequisite::class => CoursePrerequisitePolicy::class,
        Faculty::class => FacultyPolicy::class,
        Lecturer::class => LecturerPolicy::class,
        Major::class => MajorPolicy::class,
        Room::class => RoomPolicy::class,
        Season::class => SeasonPolicy::class,
        StudentAttendance::class => StudentAttendancePolicy::class,
        StudentGrade::class => StudentGradePolicy::class,
        Student::class => StudentPolicy::class,
        StudentSeasonLog::class => StudentSeasonLogPolicy::class,
        TuitionPayment::class => TuitionPaymentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
