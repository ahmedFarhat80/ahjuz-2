<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Percent()
 * @method static static Fixed()
 */
final class CouponType extends Enum
{
    const Percent =   1;
    const Fixed = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Percent:
                return 'نسبة مئوية'; break;
            case self::Fixed:
                return 'ثابت'; break;
            default:
                return parent::getDescription($value); break;
        }
    }
}
