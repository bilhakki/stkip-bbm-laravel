<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\StudentAttendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StudentAttendancePolicy
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
    public function view(User $user, StudentAttendance $studentAttendance): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudentAttendance $studentAttendance): Response
    {
        // Mahasiswa tidak dapat mengupdate absensi
        if ($user->role === UserRole::STUDENT) {
            return Response::deny('Anda tidak memiliki izin untuk mengupdate absensi.');
        }

        // Admin, akademik, dan dosen dapat mengupdate absensi mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR, UserRole::LECTURER])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengupdate absensi.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudentAttendance $studentAttendance): Response
    {
        // Admin, akademik, dan dosen dapat menghapus absensi mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus absensi.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudentAttendance $studentAttendance): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan absensi yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudentAttendance $studentAttendance): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen absensi.');
    }
}

