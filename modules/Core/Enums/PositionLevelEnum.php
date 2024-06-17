<?php

namespace Modules\Core\Enums;

enum PositionLevelEnum: int
{
    case CHAIRMAN = 1;
    case COCHAIRMAN = 2;
    case SECRETARY = 3;
    case TREASURER = 4;
    case COUNCIL = 5;
    case COSECRETARY = 6;
    case COTREASURER = 7;
    case PLENO = 8;
    case DIVISION = 9;
    case MEMBER = 10;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::CHAIRMAN => 'Ketua umum',
            self::COCHAIRMAN => 'Wakil ketua',
            self::SECRETARY => 'Sekrtaris',
            self::TREASURER => 'Bendahara',
            self::COUNCIL => 'Dewan guru',
            self::COSECRETARY => 'Wakil sekrtaris',
            self::COTREASURER => 'Wakil bendahara',
            self::PLENO => 'Anggota pleno',
            self::DIVISION => 'Kepala divisi',
            self::MEMBER => 'Anggota',
        };
    }
}
