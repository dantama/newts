<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Account\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_SEED')) {

            $this->call([
                AppDatabaseSeeder::class,
                \Modules\Account\Database\Seeders\AccountDatabaseSeeder::class,
                \Modules\Core\Database\Seeders\DepartementSeeder::class,
                \Modules\Core\Database\Seeders\LevelSeeder::class,
                \Modules\Core\Database\Seeders\ContractSeeder::class,
                \Modules\Core\Database\Seeders\PositionSeeder::class,
                \Modules\Core\Database\Seeders\OrganizationSeeder::class,
                \Modules\Core\Database\Seeders\OrganizationPositionSeeder::class,
                \Modules\Reference\Database\Seeders\ReferenceDatabaseSeeder::class,
                \Modules\Core\Database\Seeders\MemberSeeder::class,
            ]);

            DB::insert('insert into user_roles (role_id, user_id) values (?, ?)', [1, User::first()->id]);
        }
    }
}
