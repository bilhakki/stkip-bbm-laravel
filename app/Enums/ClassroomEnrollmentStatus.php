<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class ClassroomEnrollmentStatus extends Enum
{
    const PENDING = "pending";
    const APPROVED = "approved";
    const REJECTED = "rejected";


    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}