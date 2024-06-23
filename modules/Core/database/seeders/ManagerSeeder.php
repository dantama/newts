<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Account\Models\User;
use Modules\Core\Models\Manager;
use Modules\Core\Models\Unit;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the JSON file
        $jsonPath = base_path('modules/Core/Database/Seeders/manager.json');

        // Read the JSON file
        $json = File::get($jsonPath);

        // Decode JSON data into an array
        $data = json_decode($json, true);

        foreach ($data as $value) {
            $user = User::whereMeta('profile_old_id', $value['user_id'])->first();
            switch ($value['type']) {
                case '1':
                    $unit = Unit::whereType($value['type'])->whereId(1)->first();
                    break;

                case '2':
                case '3':
                    $unit = Unit::whereType($value['type'])->whereMeta('org_prov_id', $value['unit'])->first();
                    break;

                case '4':
                    $unit = Unit::whereType($value['type'])->whereMeta('org_regency_id', $value['unit'])->first();
                    break;

                default:
                    $unit = '';
                    break;
            }

            if (!empty($user->member) && !empty($unit->unit_departements)) {
                $manager = new Manager([
                    'member_id' => $user->member->id,
                    'unit_dept_id' => $unit->unit_departements->first()->id ?? '',
                    'start_at' => null,
                    'end_at' => null,
                    'meta' => $value
                ]);
                if ($manager->save()) {
                    $poss = $unit->unit_positions()->where('position_id', $value['position_id'])->first();
                    if (!empty($poss)) {
                        $manager->contracts()->create(
                            [
                                'kd' => 'surat-keterangan-manager-' . $manager->id,
                                'contract_id' => 1,
                                'unit_position_id' => $poss->id,
                            ]
                        );
                    }
                }
            }
        }
    }
}
