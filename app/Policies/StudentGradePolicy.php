<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\StudentGrade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StudentGradePolicy
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
    public function view(User $user, StudentGrade $studentGrade): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Akademik dan admin dapat membuat nilai
        if (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        }

        // Dosen dapat membuat nilai untuk mahasiswa yang menjadi perwalihannya
        if ($user->role === UserRole::LECTURER) {
            return function ($user, $studentGrade) {
                $lecturerStudentIds = $user->lecturer->students->pluck('id')->toArray();
                return in_array($studentGrade->student_id, $lecturerStudentIds)
                    ? Response::allow()
                    : Response::deny('Anda tidak memiliki izin untuk membuat nilai untuk mahasiswa ini.');
            };
        }

        // Mahasiswa dan peran lainnya tidak dapat membuat nilai
        return Response::deny('Anda tidak memiliki izin untuk membuat nilai.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudentGrade $studentGrade): Response
    {
        // Dosen dapat mengupdate nilai untuk mahasiswa yang menjadi perwalihannya
        if ($user->role === UserRole::LECTURER) {
            $lecturerStudentIds = $user->lecturer->students->pluck('id')->toArray();
            return in_array($studentGrade->student_id, $lecturerStudentIds)
                ? Response::allow()
                : Response::deny('Anda tidak memiliki izin untuk mengupdate nilai untuk mahasiswa ini.');
        }

        // Akademik dan admin dapat mengupdate nilai mahasiswa
        if (in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])) {
            return Response::allow();
        }

        return Response::deny('Anda tidak memiliki izin untuk mengupdate nilai.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudentGrade $studentGrade): Response
    {
        return in_array($user->role, [UserRole::ADMIN, UserRole::ACADEMIC_UNIVERSITY, UserRole::ACADEMIC_FACULTY, UserRole::ACADEMIC_MAJOR])
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus nilai.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudentGrade $studentGrade): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengembalikan nilai yang telah dihapus.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudentGrade $studentGrade): Response
    {
        return $user->role === UserRole::ADMIN
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk menghapus permanen nilai.');
    }
}

