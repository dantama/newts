<?php

namespace Modules\Core\Repositories;

use Modules\Core\Enums\OrganizationTypeEnum;
use Modules\Core\Models\Unit;

trait UnitRepository
{
    public function transformUnit(Unit $unit)
    {
        switch ($unit->type) {
            case OrganizationTypeEnum::CENTER:
                $units = $unit->children()->children()->flatten()->pluck('id')->toArray();
                break;

            case OrganizationTypeEnum::REGION:
                $units = $unit->children()->pluck('id')->toArray();
                break;

            case OrganizationTypeEnum::PERWIL:
            case OrganizationTypeEnum::AREA:
                $units = array($unit->id);
                break;

            case OrganizationTypeEnum::BRANCH:
                $units = $unit->parents()->pluck('id')->toArray();
                break;

            default:
                $units = [];
                break;
        }
        return $units;
    }
}
