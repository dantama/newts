<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Account\Models\User;
use Modules\Core\Models\Unit;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the JSON file
        $jsonPath = base_path('modules/Core/Database/Seeders/member.json');

        // Read the JSON file
        $json = File::get($jsonPath);

        // Decode JSON data into an array
        $data = json_decode($json, true);

        foreach ($data as $value) {
            // Create the user
            $user = new User([
                ...Arr::except($value, ['meta', 'member', 'email']),
                'email_address' => $value['email']
            ]);
            if ($user->save()) {
                // Change to current password
                DB::table($user->getTable())->where('id', $user->id)->update(['password' => $value['password']]);
                // Set meta data for the main unit
                if (!empty($value['meta'])) {
                    foreach ($value['meta'] as $key => $val) {
                        $user->setMeta($key, $val);
                    }
                }
                // Handle provinces
                if (!empty($value['member'])) {
                    $org = Unit::whereMeta('org_code', '=', $value['member']['pimda'])->first()->id;
                    $member = $user->member()->create([
                        ...Arr::except($value['member'], ['regency', 'pimda', 'joined_at', 'level']),
                        'type' => 1,
                        'joined_at' => now(),
                        'unit_id' => $org
                    ]);
                    $member->setMeta('joined_at', $value['meta']['joined_at']);
                    $data = collect($value['member']['level'])->first();
                    if (!empty($data)) {
                        $member->level()->create([
                            'level_id' => $data['level_id'],
                            'meta' => $data['meta']
                        ]);
                    }
                }
            }
        }
    }
}
