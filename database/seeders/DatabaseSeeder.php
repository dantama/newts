<?php

namespace Database\Seeders;

use Database\Seeders\ContractSeeder;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Account\Models\Employee;
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
                ContractSeeder::class,
                // EvaluationSeeder::class,
                \Modules\Account\Database\Seeders\AccountDatabaseSeeder::class,
            ]);

            $users = User::all();

            foreach ($users as $user) {
                $user->employee()->create([
                    'joined_at' => Carbon::parse(now()),
                ]);
            }

            $employees = Employee::all();

            foreach ($employees as $key => $empl) {
                if ($key === 0) {
                    $contract = $empl->contract()->create([
                        'kd' => ($key + 1) . '/EMPOWER/SKPKWT/XII/2023',
                        'contract_id' => 2,
                        'work_location' => 1,
                        'start_at' => '2021-01-01 01:00:00',
                        'end_at' => null,
                        'created_by' => $users->first()->id,
                        'updated_by' => $users->first()->id
                    ]);
                } else {
                    $contract = $empl->contract()->create([
                        'kd' => ($key + 1) . '/EMPOWER/SKPKWT/XII/2023',
                        'contract_id' => 1,
                        'work_location' => 1,
                        'start_at' => '2022-01-01 01:00:00',
                        'end_at' => '2024-12-31 23:59:00',
                        'created_by' => $users->first()->id,
                        'updated_by' => $users->first()->id
                    ]);
                }
            }

            DB::insert('insert into user_roles (role_id, user_id) values (?, ?)', [1, $users->first()->id]);
        }
    }
}
