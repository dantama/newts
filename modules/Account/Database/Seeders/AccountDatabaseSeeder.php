<?php

namespace Modules\Account\Database\Seeders;

use Modules\Account\Models\User;
use Illuminate\Database\Seeder;

class AccountDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();

        $users = User::all();

        foreach ($users as $key => $value) {
            $value->setMeta('profile_sex', rand(1, 2));
            $value->setMeta('profile_religion', rand(1, 2));
            $value->setMeta('profile_mariage', rand(1, 2));
        }

        $user = $users->first();
        $user->update(['username' => 'empower']);
    }
}
