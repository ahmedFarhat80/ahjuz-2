<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Accepted()
 * @method static static Rejected()
 * @method static static Suspended()
 */
final class PropertyStatus extends Enum
{
    const Pending    =   1;
    const Accepted   =   2;
    const Rejected   =   3;
    const Suspended  =   4;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Pending:
                return 'معلق'; break;
            case self::Accepted:
                return 'مقبول'; break;
            case self::Rejected:
                return 'مرفوض'; break;
            case self::Suspended:
                return 'موقوف'; break;
            default:
                return parent::getDescription($value); break;
        }
    }

    public static function getNoun($value)
    {
        return [
            self::Accepted  => 'تشغيل',
            self::Rejected  => 'رفض',
            self::Suspended => 'إيقاف',
        ][$value];
    }
}
