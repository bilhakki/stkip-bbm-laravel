<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class Gender extends Enum
{
    const MALE = "male";
    const FEMALE = "female";
    const OTHER = "other";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}