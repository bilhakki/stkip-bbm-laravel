<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class UserRole extends Enum
{
    const ADMIN = "admin";
    const ACADEMIC_UNIVERSITY = "academic_university";
    const ACADEMIC_FACULTY = "academic_faculty";
    const ACADEMIC_MAJOR = "academic_major";
    const LECTURER = "lecturer";
    const STUDENT = "student";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}
