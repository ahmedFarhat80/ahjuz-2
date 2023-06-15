<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Paid()
 * @method static static Canceled()
 */
final class BookingStatus extends Enum
{
    const Paid =   1;
    const Canceled =   2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Paid:
                return 'مدفوع'; break;
            case self::Canceled:
                return 'ملغي'; break;
            default:
                return parent::getDescription($value); break;
        }
    }
}
