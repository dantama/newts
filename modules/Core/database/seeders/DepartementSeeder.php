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
            'Pimpinan pusat',
            'Pimpinan wilayah',
            'Pimpinan daerah',
            'Pimpinan cabang',
            'Departemen kependekaran dan keanggotaan',
            'Departemen pembinaan keilmuan',
            'Departemen pembinaan fisik dan mental',
            'Departemen pembinaan KOSEGU',
            'Departemen pembinaan prestasi pencak silat olah raga',
            'Departemen pembinaan seni',
            'Departemen pembinaan wasit juri',
            'Departemen penelitian dan pengembangan',
            'Departemen pembinaan organisasi dalam dan luar negeri',
            'Departemen pembinaan kader',
            'Departemen pembinaan Al-Islam dan ke-Muhammadiyah-an',
            'Departemen pendayagunaan sumber daya dan usaha',
            'Departemen pendayagunaan disiplin dan hukum',
            'Departemen antar lembaga',
            'Departemen informasi dan komunikasi',
        ];

        foreach ($depts as $dept) {
            $string = str_replace(['(', ')', ','], '', $dept);
            Departement::create([
                'kd'   => Str::lower(str_replace(' ', '-', $string)),
                'name' => $dept,
                'is_visible' => 1
            ]);
        }
    }
}
