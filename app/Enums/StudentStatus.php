<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class StudentStatus extends Enum
{
    const ACTIVE = "active";
    const INACTIVE = "inactive";
    const GRADUATE = "graduate";
    const DROPOUT = "dropout";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}