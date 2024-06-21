<?php

namespace Modules\Core\Enums;

use Modules\Core\Models\Level;

enum MembershipTypeEnum: int
{
    case MEMBER = 1;
    case STUDENT = 2;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::MEMBER => 'Anggota',
            self::STUDENT => 'Siswa',
        };
    }

    /**
     * Get the label accessor with label() object
     */
    public function code(): array
    {
        return match ($this) {
            self::MEMBER => [LevelTypeEnum::CADRE->value, LevelTypeEnum::WARRIOR->value],
            self::STUDENT => [LevelTypeEnum::STUDENT->value],
        };
    }

    /**
     * Get the label accessor with label() object
     */
    public function levels(): array
    {
        return match ($this) {
            self::MEMBER => Level::whereIn('type', [LevelTypeEnum::CADRE->value, LevelTypeEnum::WARRIOR->value])->pluck('name', 'id')->toArray(),
            self::STUDENT => Level::whereIn('type', [LevelTypeEnum::STUDENT->value])->pluck('name', 'id')->toArray(),
        };
    }
}
