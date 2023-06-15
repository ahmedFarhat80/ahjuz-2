<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Knet()
 * @method static static Credit()
 */
final class PaymentMethod extends Enum
{
    const Knet =   1;
    const Credit = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Knet:
                return 'كي نت'; break;
            case self::Credit:
                return 'بطاقة إئتمان'; break;
            default:
                return parent::getDescription($value); break;
        }
    }

}
