<?php

namespace Modules\Core\Enums;

enum LevelTypeEnum: int
{
    case WARRIOR = 1;
    case CADRE = 2;
    case STUDENT = 3;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::WARRIOR => 'Pendekar',
            self::CADRE => 'Kader',
            self::STUDENT => 'Siswa',
        };
    }

    /**
     * Get the label accessor with color() object
     */
    public function color(): string
    {
        return match ($this) {
            self::WARRIOR => 'danger',
            self::CADRE => 'primary',
            self::STUDENT => 'success',
        };
    }

    /**
     * Get the label accessor with icon() object
     */
    public function icon(): string
    {
        return match ($this) {
            self::WARRIOR => 'mdi mdi-account',
            self::CADRE => 'mdi mdi-account',
            self::STUDENT => 'mdi mdi-account',
        };
    }
}
