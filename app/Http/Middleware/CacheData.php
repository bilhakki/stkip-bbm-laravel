<?php

namespace App\Http\Middleware;

use App\Models\Faculty;
use App\Models\Major;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->setFacultiesMajorsCache();
        $this->setRoleCache();

        return $next($request);
    }

    function setRoleCache()
    {
        $routes = [
            "login",
            "logout",
            "password.request",
            "password.reset",
            "password.email",
            "password.update",
            "register",
            "user-profile-information.update",
            "user-password.update",
            "password.confirmation",
            "password.confirm",
            "terms.show",
            "policy.show",
            "profile.show",
            "dashboard",
            "classroom.index",
            "classroom.create",
            "classroom.store",
            "classroom.show",
            "classroom.edit",
            "classroom.update",
            "classroom.destroy",
            "classroom-enrollment.index",
            "classroom-enrollment.create",
            "classroom-enrollment.store",
            "classroom-enrollment.show",
            "classroom-enrollment.edit",
            "classroom-enrollment.update",
            "classroom-enrollment.destroy",
            "classroom-session.index",
            "classroom-session.create",
            "classroom-session.store",
            "classroom-session.show",
            "classroom-session.edit",
            "classroom-session.update",
            "classroom-session.destroy",
            "course.index",
            "course.create",
            "course.store",
            "course.show",
            "course.edit",
            "course.update",
            "course.destroy",
            "course-prerequisite.index",
            "course-prerequisite.create",
            "course-prerequisite.store",
            "course-prerequisite.show",
            "course-prerequisite.edit",
            "course-prerequisite.update",
            "course-prerequisite.destroy",
            "faculty.index",
            "faculty.create",
            "faculty.store",
            "faculty.show",
            "faculty.edit",
            "faculty.update",
            "faculty.destroy",
            "lecturer.index",
            "lecturer.create",
            "lecturer.store",
            "lecturer.show",
            "lecturer.edit",
            "lecturer.update",
            "lecturer.destroy",
            "major.index",
            "major.create",
            "major.store",
            "major.show",
            "major.edit",
            "major.update",
            "major.destroy",
            "room.index",
            "room.create",
            "room.store",
            "room.show",
            "room.edit",
            "room.update",
            "room.destroy",
            "season.index",
            "season.create",
            "season.store",
            "season.show",
            "season.edit",
            "season.update",
            "season.destroy",
            "student.index",
            "student.create",
            "student.store",
            "student.show",
            "student.edit",
            "student.update",
            "student.destroy",
            "student-attendance.index",
            "student-attendance.create",
            "student-attendance.store",
            "student-attendance.show",
            "student-attendance.edit",
            "student-attendance.update",
            "student-attendance.destroy",
            "student-grade.index",
            "student-grade.create",
            "student-grade.store",
            "student-grade.show",
            "student-grade.edit",
            "student-grade.update",
            "student-grade.destroy",
            "tuition-payment.index",
            "tuition-payment.create",
            "tuition-payment.store",
            "tuition-payment.show",
            "tuition-payment.edit",
            "tuition-payment.update",
            "tuition-payment.destroy"
        ];
        $defaultRoles = [
            "ADMIN" => [...$routes],
            "ACADEMIC_UNIVERSITY" => [],
            "ACADEMIC_FACULTY" => [],
            "ACADEMIC_MAJOR" => [],
            "LECTURER" => [],
            "MAHASISWA" => [],
        ];
        if (!Cache::has("setting:role:keys")) {
            Cache::forever("setting:role:keys", array_keys($defaultRoles));
        }

        foreach ($defaultRoles as $key => $defaultRole) {
            if (!Cache::has("setting:role:$key")) {
                Cache::forever("setting:role:$key", $defaultRole);
            }
        }
        return;
    }
    function setFacultiesMajorsCache()
    {
        if (!Cache::has('faculties')) {
            Cache::forever('faculties', Faculty::all());
        }
        if (!Cache::has('majors')) {
            Cache::forever('majors', Major::all());
        }
        return;
    }
}
