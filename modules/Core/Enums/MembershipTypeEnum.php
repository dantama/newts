<?php

namespace App\Enums;

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
}
