<?php

namespace Modules\Core\Enums;

use Modules\Core\Models\Unit;
use Modules\Reference\Models\Province;
use Modules\Reference\Models\ProvinceRegency;
use Modules\Reference\Models\ProvinceRegencyDistrict;

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
     * Get the prefix accessor with prefix() object
     */
    public function prefix(): string
    {
        return match ($this) {
            self::CENTER => 'Pimpinan pusat',
            self::REGION => 'Pimpinan wilayah',
            self::PERWIL => 'Perwakilan wilayah',
            self::AREA   => 'Pimpinan Daerah',
            self::BRANCH => 'Pimpinan Cabang'
        };
    }

    /**
     * Get the alias accessor with alias() object
     */
    public function alias(): string
    {
        return match ($this) {
            self::CENTER => '',
            self::REGION => 'PIMWIL',
            self::PERWIL => 'PERWIL',
            self::AREA   => 'PIMDA',
            self::BRANCH => 'PIMCAB'
        };
    }

    /**
     * Get the prefix accessor with prefix() object
     */
    public function color(): string
    {
        return match ($this) {
            self::CENTER => 'bg-danger text-light',
            self::REGION => 'bg-primary text-light',
            self::PERWIL => 'bg-info text-light',
            self::AREA   => 'bg-success text-light',
            self::BRANCH => 'bg-secondary text-light'
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

    /**
     * Get the unit accessor with units() object
     */
    public function units()
    {
        return match ($this) {
            self::CENTER => '',
            self::REGION => Unit::where('type', self::CENTER->value)->get(),
            self::PERWIL => Unit::where('type', self::CENTER->value)->get(),
            self::AREA   => Unit::where('type', self::REGION->value)->get(),
            self::BRANCH => Unit::where('type', self::AREA->value)->get()
        };
    }

    /**
     * Get the label accessor with label() object
     */
    public function states()
    {
        return match ($this) {
            self::CENTER => '',
            self::REGION => Province::all(),
            self::PERWIL => '',
            self::AREA   => ProvinceRegency::all(),
            self::BRANCH => ProvinceRegencyDistrict::all()
        };
    }
}
