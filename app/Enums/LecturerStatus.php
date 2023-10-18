<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class LecturerStatus extends Enum
{
    const ACTIVE = "active";
    const INACTIVE = "inactive";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}
