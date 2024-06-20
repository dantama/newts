<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Enums\PositionLevelEnum;
use Modules\Core\Models\Unit;
use Modules\Core\Models\UnitDepartement;
use Modules\Core\Models\UnitPosition;

class OrganizationPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = array(
            array(
                "id" => 1,
                "name" => "KETUA UMUM",
                'level' => PositionLevelEnum::CHAIRMAN
            ),
            array(
                "id" => 2,
                "name" => "WAKIL KETUA UMUM",
                'level' => PositionLevelEnum::COCHAIRMAN,
                'parent_ids' => [1]
            ),
            array(
                "id" => 3,
                "name" => "SEKRETARIS UMUM",
                'level' => PositionLevelEnum::SECRETARY,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 4,
                "name" => "BENDAHARA UMUM",
                'level' => PositionLevelEnum::TREASURER,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 5,
                "name" => "DEWAN GURU",
                'level' => PositionLevelEnum::COUNCIL,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 6,
                "name" => "SEKRETARIS I",
                'level' => PositionLevelEnum::COSECRETARY,
                'parent_ids' => [1, 2, 3]
            ),
            array(
                "id" => 7,
                "name" => "SEKRETARIS II",
                'level' => PositionLevelEnum::COSECRETARY,
                'parent_ids' => [1, 2, 3]
            ),
            array(
                "id" => 8,
                "name" => "BENDAHARA I",
                'level' => PositionLevelEnum::COTREASURER,
                'parent_ids' => [1, 2, 4]
            ),
            array(
                "id" => 9,
                "name" => "BENDAHARA II",
                'level' => PositionLevelEnum::COTREASURER,
                'parent_ids' => [1, 2, 4]
            ),
            array(
                "id" => 36,
                "name" => "ANGGOTA PLENO",
                'level' => PositionLevelEnum::PLENO,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 37,
                "name" => "ANGGOTA",
                'level' => PositionLevelEnum::MEMBER,
                'parent_ids' => [1, 2]
            ),
        );

        $unitdepts = Unit::all();

        foreach ($unitdepts as $unit) {
            foreach ($positions as $poss) {
                UnitPosition::create([
                    'unit_id' => $unit->id,
                    'position_id' => $poss['id'],
                ]);
            }
        }
    }
}
