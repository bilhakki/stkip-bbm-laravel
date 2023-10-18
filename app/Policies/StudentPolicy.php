<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StudentPolicy
{
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
    public function view(User $user, Student $student): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk membuat data mahasiswa.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Student $student): Response
    {
        // Mahasiswa dapat mengupdate dirinya sendiri
        if ($user->role === UserRole::STUDENT && $user->id === $student->user_id) {
            return Response::allow();
        }

        // Akademik dan admin dapat mengupdate mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengupdate data mahasiswa.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Student $student): Response
    {
        // Akademik dan admin dapat menghapus mahasiswa
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus data mahasiswa.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Student $student): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan data mahasiswa yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $student): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen data mahasiswa.');
    }
}
