<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Family()
 * @method static static All()
 */
final class PropertyFor extends Enum
{
    const Family =   1;
    const All = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Family:
                return 'للعائلات فقط'; break;
            case self::All:
                return 'للعائلات و العزاب'; break;
            default:
                return parent::getDescription($value); break;
        }
    }
}
