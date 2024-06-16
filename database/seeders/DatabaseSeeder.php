<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            ]);

            $users = User::all();

            foreach ($users as $user) {
                $user->member()->create([
                    'type' => 1,
                    'joined_at' => Carbon::parse(now()),
                ]);
            }

            DB::insert('insert into user_roles (role_id, user_id) values (?, ?)', [1, $users->first()->id]);
        }
    }
}
