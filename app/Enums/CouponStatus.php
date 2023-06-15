<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Suspended()
 * @method static static Active()
 */
final class CouponStatus extends Enum
{
    const Suspended =   1;
    const Active = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Active:
                return 'نشط'; break;
            case self::Suspended:
                return 'متوقف'; break;
            default:
                return parent::getDescription($value); break;
        }
    }
}
