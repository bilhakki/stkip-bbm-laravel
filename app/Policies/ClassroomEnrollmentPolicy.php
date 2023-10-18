<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ClassroomEnrollment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ClassroomEnrollmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClassroomEnrollment $classroomEnrollment): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, [UserRole::STUDENT, UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk membuat data pendaftaran kelas.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClassroomEnrollment $classroomEnrollment): Response
    {
        if ($user->role === UserRole::STUDENT && $user->id === $classroomEnrollment->student_id) {
            return Response::allow();
        } elseif ($user->role === UserRole::LECTURER && $user->advisees->contains('id', $classroomEnrollment->student_id)) {
            return Response::allow();
        } elseif (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        }

        return Response::deny('Anda tidak memiliki izin untuk mengupdate data pendaftaran kelas ini.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClassroomEnrollment $classroomEnrollment): Response
    {
        if ($user->role === UserRole::STUDENT && $user->id === $classroomEnrollment->student_id) {
            return Response::allow();
        } elseif ($user->role === UserRole::LECTURER) {
            return Response::deny('Anda tidak diizinkan untuk menghapus pendaftaran kelas.');
        } elseif (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        }

        return Response::deny('Anda tidak memiliki izin untuk menghapus data pendaftaran kelas ini.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClassroomEnrollment $classroomEnrollment): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan data pendaftaran kelas yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassroomEnrollment $classroomEnrollment): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen data pendaftaran kelas.');
    }
}
