<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\ClassroomSession;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class ClassroomSessionPolicy
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
    public function view(User $user, ClassroomSession $classroomSession): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::LECTURER, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk membuat sesi kelas.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClassroomSession $classroomSession): Response
    {
        if ($user->id === $classroomSession->lecturer_id && ($user->role === UserRole::LECTURER)) {
            return Response::allow();
        } elseif (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        } else {
            return Response::deny('Anda tidak memiliki izin untuk mengupdate sesi kelas.');
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClassroomSession $classroomSession): Response
    {
        if ($user->id === $classroomSession->lecturer_id && ($user->role === UserRole::LECTURER)) {
            return Response::allow();
        } elseif (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        } else {
            return Response::deny('Anda tidak memiliki izin untuk menghapus sesi kelas.');
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClassroomSession $classroomSession): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan sesi kelas yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassroomSession $classroomSession): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen sesi kelas.');
    }
}
