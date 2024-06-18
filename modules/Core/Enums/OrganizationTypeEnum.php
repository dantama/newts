<?php

namespace Modules\Core\Enums;

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

    /**
     * Get the label accessor with label() object
     */
    public function depts(): array
    {
        return match ($this) {
            self::CENTER => [1, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            self::REGION => [2, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            self::PERWIL => [2],
            self::AREA   => [3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
            self::BRANCH => [4]
        };
    }
}
