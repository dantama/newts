<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contracts = [
            'pkwt' => 'Perjanjian Kerja Waktu Tertentu',
            'pkwtt' => 'Perjanjian Kerja Waktu Tidak Tertentu',
            'magang' => 'Management Training (Magang)',
            'honorer' => 'Honorer',
        ];

        foreach ($contracts as $kd => $name) {
            Contract::create(compact('kd', 'name'));
        }
    }
}
