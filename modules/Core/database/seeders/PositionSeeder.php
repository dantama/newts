<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Enums\PositionLevelEnum;
use Modules\Core\Models\Position;

class PositionSeeder extends Seeder
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
                "id" => 10,
                "name" => "DEPT. PEMBINAAN DAN PENDIDIKAN / KET. DEWAN PENDEKAR",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 11,
                "name" => "BIDANG KEPENDEKARAN DAN KEANGGOTAAN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 12,
                "name" => "BIDANG PEMBINAAN KEILMUAN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 13,
                "name" => "BIDANG FISIK DAN MENTAL",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 14,
                "name" => "BIDANG PEMBINAAN ANGGOTA",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 15,
                "name" => "DEPT. PEMBINAAN PRESTASI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 16,
                "name" => "BIDANG PEMBINAAN PRESTASI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 17,
                "name" => "BIDANG PEMBINAAN KEPELATIHAN PRESTASI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 18,
                "name" => "BIDANG PEMBINAAN WASIT JURI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 19,
                "name" => "BIDANG PEMBINAAN KOSEGU",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 20,
                "name" => "DEPT. PEMBINAAN ORGANESASI DAN KADER",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 21,
                "name" => "BIDANG PEMBINAAN ORGANESASI DALAM DAN LUAR NEGERI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 22,
                "name" => "BIDANG PEMBINAAN PENGKADERAN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 23,
                "name" => "BIDANG PEMBINAAN AL-ISLAM DAN KE-MUHAMMADIYAH-AN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 24,
                "name" => "DEPT. PENDAYAGUNAAN SUMBER DAYA",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 25,
                "name" => "BIDANG PENDAYAGUNAAN SUMBER DANA",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 26,
                "name" => "BIDANG PENDAYAGUNAAN USAHA",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 27,
                "name" => "BIDANG PENDAYA GUNAAN DISIPLIN DAN HUKUM",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 28,
                "name" => "DEPARTEMEN PENGEMBANGAN DAN PENELITIAN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 29,
                "name" => "BIDANGPENELITIAN DAN PENGEMBANGAN PESILAT",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 30,
                "name" => "BIDANG PENELITIAN DAN PENEGEMBANGAN PELATIH",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 31,
                "name" => "BIDANG PENELITIAN DAN PENGEMBANGAN WASIT JURI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 32,
                "name" => "DEPT. HUBUNGAN MASYARAKAT",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 33,
                "name" => "BIDANG PROMOSI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 34,
                "name" => "BIDANG KOMUNIKASI DAN PENERBITAN",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
            ),
            array(
                "id" => 35,
                "name" => "BIDANG INFORMASI",
                'level' => PositionLevelEnum::DIVISION,
                'parent_ids' => [1, 2]
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


        foreach ($positions as $poss) {
            $string = str_replace(['(', ')', ','], '', $poss['name']);
            $p = Position::create([
                'kd'   => Str::lower(str_replace(' ', '-', $string)),
                'name' => $poss['name'],
                'level' => $poss['level']
            ]);

            if (isset($poss['parent_ids']))
                $p->parents()->sync($poss['parent_ids']);
        }
    }
}
