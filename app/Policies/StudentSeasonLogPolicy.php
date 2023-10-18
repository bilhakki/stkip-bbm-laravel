<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\StudentSeasonLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StudentSeasonLogPolicy
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
    public function view(User $user, StudentSeasonLog $studentSeasonLog): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Admin dan akademik dapat membuat log mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk membuat log mahasiswa.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudentSeasonLog $studentSeasonLog): Response
    {
        // Admin dan akademik memiliki hak penuh untuk mengupdate semua log mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengupdate log mahasiswa.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudentSeasonLog $studentSeasonLog): Response
    {
        // Admin dan akademik memiliki hak penuh untuk menghapus semua log mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus log mahasiswa.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudentSeasonLog $studentSeasonLog): Response
    {
        // Admin memiliki hak penuh untuk mengembalikan log mahasiswa
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan log mahasiswa yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudentSeasonLog $studentSeasonLog): Response
    {
        // Admin memiliki hak penuh untuk menghapus permanen log mahasiswa
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen log mahasiswa.');
    }
}
