<?php

namespace App\Enums;

enum OrganizationTypeEnum: int
{
    case CENTER = 1;
    case PROVINCE = 2;
    case PERWIL = 3;
    case REGION = 4;
    case AREA = 5;
    case BRANCH = 6;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::CENTER => 'Pusat',
            self::PROVINCE => 'Provinsi',
            self::PERWIL => 'Perwakilan wilayah',
            self::REGION => 'Wilayah',
            self::AREA => 'Daerah',
            self::BRANCH => 'Cabanng'
        };
    }
}
