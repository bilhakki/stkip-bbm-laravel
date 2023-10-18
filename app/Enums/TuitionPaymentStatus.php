<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class TuitionPaymentStatus extends Enum
{
    const PENDING = "pending";
    const PAID = "paid";
    const EXPIRED = "expired";
    const FAILED = "failed";

    public static function values(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        return array_values($reflectionClass->getConstants());
    }
}
