<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class StudentAttendanceStatus extends Enum
{
    const PRESENT = "present";
    const ABSENT = "absent";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}
