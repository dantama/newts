<?php

namespace Modules\Core\Models\Traits;

use Modules\Account\Models\User;
use Faker\Factory as Faker;
use Modules\Core\Enums\MembershipTypeEnum;
use Modules\Core\Models\Unit;

trait MemberTrait
{
    /**
     * Complete insert.
     */
    public static function completeInsertViaImport($data)
    {
        $faker = Faker::create();

        $user = new User([
            'username'  => $faker->unique()->username(),
            'name'  => $data['name'],
            'password'  => bcrypt('#password12345'),
            'email_address' => $faker->unique()->safeEmail,
        ]);

        $user->save();

        $user->setMeta('profile_sex', ($data['sex'] + 1));
        $user->setMeta('profile_pob', $data['pob']);
        $user->setMeta('profile_dob', $data['dob']);
        $user->setMeta('profile_address', $data['address']);

        $unit = Unit::whereMeta('org_code', '=', $data['pimda'])->first()->id;

        $member = $user->member()->create([
            'type' => 1,
            'unit_id' => $unit,
            'nbts' => $data['nbts'],
            'nbm' => $data['nbm'],
            'joined_at' => now()
        ]);

        $member->setMeta('joined_at', $data['joined_at']);

        if (!empty($data['level'])) {
            $member->level()->create([
                'level_id' => $data['level'],
                'meta' => $data['meta'] ?? null
            ]);
        }
    }
}
