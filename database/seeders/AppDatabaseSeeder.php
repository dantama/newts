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
            'app_short_name' => 'EPK',
            'app_name' => 'Evaluasi Penilaian Kinerja',
            'app_long_name' => 'Evaluasi Penilaian Kinerja (EPK)',
            'meta_author' => 'pemad',
            'meta_keywords' => 'website, laravel, application, app, apps',
            'meta_image' => '/img/logo/logo-icon-sq-512.png',
            'meta_description' => config('app.url'),
            'evaluation_outputs' => [
                [
                    "min" => "0",
                    "max" => "49.99",
                    "grade" => "E",
                    "description" => "Kinerja Tidak Dapat Diterima"
                ],
                [
                    "min" => "49.99",
                    "max" => "62.37",
                    "grade" => "D",
                    "description" => "Tidak memenuhi semua ekspektasi"
                ],
                [
                    "min" => "62.37",
                    "max" => "74.75",
                    "grade" => "C",
                    "description" => "Tidak memenuhi sebagian besar ekspektasi"
                ],
                [
                    "min" => "74.75",
                    "max" => "87.12",
                    "grade" => "B",
                    "description" => "Memenuhi target/ekspektasi"
                ],
                [
                    "min" => "87.12",
                    "max" => "99.50",
                    "grade" => "A",
                    "description" => "Melampaui semua target/ekspektasi"
                ],
                [
                    "min" => "99.50",
                    "max" => "100",
                    "grade" => "A+",
                    "description" => "Melampaui ekspektasi (Istimewa)"
                ]
            ],
            'evaluation_options' => [
                [
                    'score' => 0,
                    "label" => "Tidak pernah melakukan tugas ini.",
                ],
                [
                    'score' => 1,
                    "label" => "Memerlukan pelatihan, supervisi, dan coaching secara menyeluruh.",
                ],
                [
                    'score' => 2,
                    "label" => "Memerlukan pelatihan, supervisi, dan coaching untuk sebagian besar tugas.",
                ],
                [
                    'score' => 3,
                    "label" => "Memerlukan pelatihan, supervisi, dan coaching untuk beberapa tugas.",
                ],
                [
                    'score' => 4,
                    "label" => "Tidak memerlukan pelatihan, tetapi memerlukan supervisi dan coaching.",
                ],
                [
                    'score' => 5,
                    "label" => "Tidak memerlukan pelatihan, supervisi, maupun coaching."
                ]
            ],
            'evaluation_default_options' => [
                "Tidak pernah melakukan tugas ini.",
                "Memerlukan pelatihan, supervisi, dan coaching secara menyeluruh.",
                "Memerlukan pelatihan, supervisi, dan coaching untuk sebagian besar tugas.",
                "Memerlukan pelatihan, supervisi, dan coaching untuk beberapa tugas.",
                "Tidak memerlukan pelatihan, tetapi memerlukan supervisi dan coaching.",
                "Tidak memerlukan pelatihan, supervisi, maupun coaching."
            ]
        ];

        foreach ($settings as $key => $value) {
            Setting::create(compact('key', 'value'));
        }

        $permissions = [
            'App' => [
                'Config' => ['write'],
                'Departement' => ['read', 'write', 'delete'],
                'Document' => ['read', 'write', 'delete'],
                'DocumentSignature' => ['read', 'write', 'delete'],
                'Position' => ['read', 'write', 'delete'],
                'Contract' => ['read', 'write', 'delete'],
                'Role' => ['read', 'write', 'delete'],
                'Permission' => ['read', 'write', 'delete'],
            ],
            'Account' => [
                'User' => ['read', 'write', 'delete', 'cross-login'],
                'UserLog' => ['read', 'delete'],
                'Employee' => ['read', 'write', 'delete'],
                'EmployeeContract' => ['read', 'write', 'delete'],
                'EmployeePosition' => ['read', 'write', 'delete'],
            ],
            'evaluation' => [
                'Evaluation' => ['read', 'write', 'delete'],
                'EvaluationCategory' => ['read', 'write', 'delete'],
                'EvaluationEmployee' => ['read', 'write', 'delete', 'resume'],
                'EvaluationComponent' => ['read', 'write', 'delete'],
                'EvaluationResponden' => ['read', 'write', 'delete'],
                'EvaluationQuestion' => ['read', 'write', 'delete'],
                'EvaluationResponse' => ['read', 'write', 'delete'],
                'EvaluationTable' => ['read', 'write', 'delete'],
                'EvaluationSummary' => ['read', 'write', 'delete'],
                'EvaluationReport' => ['read', 'write', 'delete'],
            ],
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
                'kd' => 'director',
                'name' => 'Direktur',
                'role' => Permission::whereNotIn('key', ['cross-login-users'])->pluck('id')
            ], [
                'kd' => 'manager',
                'name' => 'Manajer',
                'role' => Permission::whereNotIn('key', ['cross-login-users'])->whereNotIn('module', ['App'])->pluck('id')
            ],
        ];

        foreach ($roles as $role) {
            $_role = Role::create(Arr::only($role, ['kd', 'name']));
            $_role->permissions()->attach($role['role']);
        }
    }
}
