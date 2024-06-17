<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Core\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the JSON file
        $jsonPath = base_path('modules/Core/Database/Seeders/organization.json');

        // Read the JSON file
        $json = File::get($jsonPath);

        // Decode JSON data into an array
        $data = json_decode($json, true);

        foreach ($data as $value) {
            // Create the main organization
            $org = new Organization(Arr::except($value, ['meta', 'provinces', 'perwils', 'parent_id']));
            if ($org->save()) {
                // Set meta data for the main organization
                if (!empty($value['meta'])) {
                    foreach ($value['meta'] as $key => $val) {
                        $org->setMeta($key, $val);
                    }
                }
                // Handle provinces
                if (!empty($value['provinces'])) {
                    foreach ($value['provinces'] as $province) {
                        // Create province as a child of the main organization
                        $provOrg = $org->children()->create(Arr::except($province, ['meta', 'regencies', 'parent_id']));
                        // Set meta data for the province
                        if (!empty($province['meta'])) {
                            foreach ($province['meta'] as $key => $val) {
                                $provOrg->setMeta($key, $val);
                            }
                        }
                        // Handle regencies
                        if (!empty($province['regencies'])) {
                            foreach ($province['regencies'] as $regency) {
                                // Create regency as a child of the province
                                $regOrg = $provOrg->children()->create(Arr::except($regency, ['meta', 'parent_id']));
                                // Set meta data for the regency
                                if (!empty($regency['meta'])) {
                                    foreach ($regency['meta'] as $key => $val) {
                                        $regOrg->setMeta($key, $val);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
