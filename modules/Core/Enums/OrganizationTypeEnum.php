<?php

namespace App\Enums;

enum OrganizationTypeEnum: int
{
    case CENTER = 1;
    case REGION = 2;
    case PERWIL = 3;
    case AREA   = 4;
    case BRANCH = 5;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::CENTER => 'Pusat',
            self::REGION => 'Wilayah',
            self::PERWIL => 'Perwakilan wilayah',
            self::AREA   => 'Daerah',
            self::BRANCH => 'Cabang'
        };
    }
}
