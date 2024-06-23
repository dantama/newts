<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Setting;
use App\Models\Permission;
use App\Models\Role;

class AppDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'app_short_name' => 'Tapak Suci',
            'app_name' => 'Tapaksuci Apps',
            'app_long_name' => 'Tapaksuci Application Management System',
            'meta_author' => 'dantama',
            'meta_keywords' => 'website, laravel, application, app, apps',
            'meta_image' => '/img/logo/logo-icon-sq-512.png',
            'meta_description' => config('app.url'),
        ];

        foreach ($settings as $key => $value) {
            Setting::create(compact('key', 'value'));
        }

        $permissions = [
            'App' => [
                'Config' => ['write'],
                'Document' => ['read', 'write', 'delete'],
                'DocumentSignature' => ['read', 'write', 'delete'],
                'Role' => ['read', 'write', 'delete'],
                'Permission' => ['read', 'write', 'delete'],
            ],
            'Account' => [
                'User' => ['read', 'write', 'delete', 'cross-login'],
                'UserLog' => ['read', 'delete'],
            ],
            'core' => [
                'Contract' => ['read', 'write', 'delete'],
                'Departement' => ['read', 'write', 'delete'],
                'Position' => ['read', 'write', 'delete'],
                'Level' => ['read', 'write', 'delete'],
                'Unit' => ['read', 'write', 'delete'],
                'UnitDepartement' => ['read', 'write', 'delete'],
                'UnitPosition' => ['read', 'write', 'delete'],
                'Member' => ['read', 'write', 'delete'],
                'MemberLevel' => ['read', 'write', 'delete'],
                'MemberAchievement' => ['read', 'write', 'delete'],
                'Manager' => ['read', 'write', 'delete'],
                'ManagerContract' => ['read', 'write', 'delete'],
            ],
            'blog' => [
                'BlogPost' => ['read', 'write', 'delete'],
                'BlogCategory' => ['read', 'write', 'delete'],
                'BlogPostComment' => ['read', 'write', 'delete'],
                'BlogPostTag' => ['read', 'write', 'delete'],
                'Subscriber' => ['read', 'write', 'delete'],
            ]
        ];

        foreach ($permissions as $module => $models) {
            foreach ($models as $model => $actions) {
                foreach ($actions as $permission) {
                    Permission::create([
                        'module' => $module,
                        'name' => ucfirst(str($permission)->append(' ' . str(str()->snake($model, ' '))->plural())),
                        'model' => $model,
                        'description' => 'Allow user to ' . strtolower(str($permission)->append(' ' . str(str()->snake($model, ' '))->plural())),
                        'key' => str()->slug(str($permission)->append(' ' . str(str()->snake($model))->plural()))
                    ]);
                }
            }
        }

        $roles = [
            [
                'kd' => 'root',
                'name' => 'Super Administrator',
                'role' => Permission::all()->pluck('id')
            ], [
                'kd' => 'admin',
                'name' => 'Administrator',
                'role' => Permission::whereNotIn('key', ['cross-login-users'])->pluck('id')
            ],
        ];

        foreach ($roles as $role) {
            $_role = Role::create(Arr::only($role, ['kd', 'name']));
            $_role->permissions()->attach($role['role']);
        }
    }
}
