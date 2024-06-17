<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Models\Level;
use Modules\Core\Enums\LevelTypeEnum;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = array(
            array(
                "id" => 1,
                "name" => "Siswa Dasar",
                "code" => "1",
                'type' => LevelTypeEnum::STUDENT
            ),
            array(
                "id" => 2,
                "name" => "Siswa 1",
                "code" => "1",
                'type' => LevelTypeEnum::STUDENT
            ),
            array(
                "id" => 3,
                "name" => "Siswa 2",
                "code" => "1",
                'type' => LevelTypeEnum::STUDENT
            ),
            array(
                "id" => 4,
                "name" => "Siswa 3",
                "code" => "1",
                'type' => LevelTypeEnum::STUDENT
            ),
            array(
                "id" => 5,
                "name" => "Siswa 4",
                "code" => "1",
                'type' => LevelTypeEnum::STUDENT
            ),
            array(
                "id" => 6,
                "name" => "Kader Dasar",
                "code" => "2",
                'type' => LevelTypeEnum::CADRE
            ),
            array(
                "id" => 7,
                "name" => "Kader Muda",
                "code" => "2",
                'type' => LevelTypeEnum::CADRE
            ),
            array(
                "id" => 8,
                "name" => "Kader Madya",
                "code" => "2",
                'type' => LevelTypeEnum::CADRE
            ),
            array(
                "id" => 9,
                "name" => "Kader Kepala",
                "code" => "2",
                'type' => LevelTypeEnum::CADRE
            ),
            array(
                "id" => 10,
                "name" => "Kader Utama",
                "code" => "2",
                'type' => LevelTypeEnum::CADRE
            ),
            array(
                "id" => 11,
                "name" => "Pendekar Muda",
                "code" => "3",
                'type' => LevelTypeEnum::WARRIOR
            ),
            array(
                "id" => 12,
                "name" => "Pendekar Madya",
                "code" => "3",
                'type' => LevelTypeEnum::WARRIOR
            ),
            array(
                "id" => 13,
                "name" => "Pendekar Kepala",
                "code" => "3",
                'type' => LevelTypeEnum::WARRIOR
            ),
            array(
                "id" => 14,
                "name" => "Pendekar Utama",
                "code" => "3",
                'type' => LevelTypeEnum::WARRIOR
            ),
            array(
                "id" => 15,
                "name" => "Pendekar Besar",
                "code" => "3",
                'type' => LevelTypeEnum::WARRIOR
            ),
        );

        foreach ($levels as $level) {
            $string = str_replace(['(', ')', ','], '', $level['name']);
            Level::create([
                'kd'   => Str::lower(str_replace(' ', '-', $string)),
                'name' => $level['name'],
                'code' => $level['code'],
                'type' => $level['type']
            ]);
        }
    }
}
