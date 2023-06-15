<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


/**
 * @method static static Chalet()
 * @method static static Farm()
 * @method static static Rest()
 * @method static static Camp()
 * @method static static Kshata()
 */
final class PropertyType extends Enum
{
    const Chalet =   1;
    const Farm =   2;
    const Rest = 3;
    const Camp = 4;
    const Kshata = 5;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Chalet:
                return 'شاليه'; break;
            case self::Farm:
                return 'مزرعة'; break;
            case self::Rest:
                return 'استراحة'; break;
            case self::Camp:
                return 'مخيم'; break;
            case self::Kshata:
                return 'كشتة'; break;
            default:
                return parent::getDescription($value); break;
        }
    }

    public static function getPluralDescriptions(): array
    {
        return [
            self::Chalet => 'شاليهات',
            self::Farm => 'مزارع',
            self::Rest => 'استراحات',
            self::Camp => 'مخيمات',
            self::Kshata => 'كشتات',
        ];
    }
}
