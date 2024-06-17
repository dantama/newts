<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Account\Models\User;
use Modules\Core\Models\Organization;

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
            // Create the main organization
            $user = new User([
                ...Arr::except($value, ['meta', 'member', 'email']),
                'email_address' => $value['email']
            ]);
            if ($user->save()) {
                // Change to current password
                DB::table($user->getTable())->where('id', $user->id)->update(['password' => $value['password']]);
                // Set meta data for the main organization
                if (!empty($value['meta'])) {
                    foreach ($value['meta'] as $key => $val) {
                        $user->setMeta($key, $val);
                    }
                }
                // Handle provinces
                if (!empty($value['member'])) {
                    $org = Organization::whereMeta('org_code', '=', $value['member']['pimda'])->first()->id;
                    $user->member()->create([
                        ...Arr::except($value['member'], ['regency', 'pimda', 'joined_at']),
                        'type' => 1,
                        'joined_at' => now(),
                        'organization_id' => $org
                    ]);
                }
            }
        }
    }
}
