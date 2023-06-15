<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static No()
 * @method static static Yes()
 */
final class PropertyIsActive extends Enum
{
    const No    =   1;
    const Yes    =   2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::No:
                return 'لا'; break;
            case self::Yes:
                return 'نعم'; break;
            default:
                return parent::getDescription($value); break;
        }
    }
}
