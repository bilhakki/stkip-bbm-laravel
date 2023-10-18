<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Academic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AcademicPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Academic $academic): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Academic $academic): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Academic $academic): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Academic $academic): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Academic $academic): Response
    {
        return $user->role === UserRole::ADMIN ? Response::allow() : Response::deny('Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
