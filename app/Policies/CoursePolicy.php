<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class CoursePolicy
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
    public function view(User $user, Course $course): Response
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
            : Response::deny('Anda tidak memiliki izin untuk membuat mata kuliah.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengupdate mata kuliah.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus mata kuliah.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan mata kuliah yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen mata kuliah.');
    }
}
