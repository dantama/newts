<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Departement;
use Illuminate\Support\Str;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $depts = [
            ['Pimpinan pusat', 0],
            ['Pimpinan wilayah', 0],
            ['Pimpinan daerah', 0],
            ['Pimpinan cabang', 0],
            ['Departemen kependekaran dan keanggotaan', 1],
            ['Departemen pembinaan keilmuan', 1],
            ['Departemen pembinaan fisik dan mental', 1],
            ['Departemen pembinaan KOSEGU', 1],
            ['Departemen pembinaan prestasi pencak silat olah raga', 1],
            ['Departemen pembinaan seni', 1],
            ['Departemen pembinaan wasit juri', 1],
            ['Departemen penelitian dan pengembangan', 1],
            ['Departemen pembinaan organisasi dalam dan luar negeri', 1],
            ['Departemen pembinaan kader', 1],
            ['Departemen pembinaan Al-Islam dan ke-Muhammadiyah-an', 1],
            ['Departemen pendayagunaan sumber daya dan usaha', 1],
            ['Departemen pendayagunaan disiplin dan hukum', 1],
            ['Departemen antar lembaga', 1],
            ['Departemen informasi dan komunikasi', 1],
        ];

        foreach ($depts as $dept) {
            $string = str_replace(['(', ')', ','], '', $dept[0]);
            Departement::create([
                'kd'   => Str::lower(str_replace(' ', '-', $string)),
                'name' => $dept[0],
                'is_visible' => 1,
                'is_addable' => $dept[1] ?? 0
            ]);
        }
    }
}
