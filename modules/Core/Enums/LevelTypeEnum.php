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
}
