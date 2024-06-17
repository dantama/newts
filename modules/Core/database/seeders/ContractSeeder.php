<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contracts = array(
            array(
                "kd" => 'sk',
                "name" => "Surat keterangan",
                "description" => "Surat keterangan",
            ),
        );

        foreach ($contracts as $contract) {
            Contract::create([
                'kd' => $contract['kd'],
                'name' => $contract['name'],
                'description' => $contract['description']
            ]);
        }
    }
}
