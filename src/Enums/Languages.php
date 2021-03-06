<?php

namespace Combindma\Blog\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static French()
 * @method static static English()
 * @method static static Arabic()
 */
final class Languages extends Enum
{
    public const French = 'fr';
    public const English = 'en';
    public const Arabic = 'ar';

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::French:
                return 'Français';
            case self::English:
                return 'Anglais';
            case self::Arabic:
                return 'Arabe';
            default:
                return parent::getDescription($value);
        }
    }
}
