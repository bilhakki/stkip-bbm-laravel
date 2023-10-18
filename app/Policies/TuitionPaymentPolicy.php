<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\TuitionPayment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;


class TuitionPaymentPolicy
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
    public function view(User $user, TuitionPayment $tuitionPayment): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR, UserRole::STUDENT])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk membuat pembayaran.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TuitionPayment $tuitionPayment): Response
    {
        if ($user->role === UserRole::STUDENT) {
            // Mahasiswa hanya dapat mengupdate pembayaran miliknya sendiri
            return $user->id === $tuitionPayment->student_id
                ? Response::allow()
                : Response::deny('Anda hanya dapat mengupdate pembayaran milik Anda sendiri.');
        }

        // Admin dan akademik memiliki hak penuh untuk mengupdate semua pembayaran
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengupdate pembayaran.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TuitionPayment $tuitionPayment): Response
    {
        // Admin dan akademik memiliki hak penuh untuk menghapus semua pembayaran
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus pembayaran.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TuitionPayment $tuitionPayment): Response
    {
        // Admin memiliki hak penuh untuk mengembalikan pembayaran
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan pembayaran yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TuitionPayment $tuitionPayment): Response
    {
        // Admin memiliki hak penuh untuk menghapus permanen pembayaran
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen pembayaran.');
    }
}
