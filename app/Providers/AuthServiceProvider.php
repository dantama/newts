<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models;
use App\Policies;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Models\Role::class => Policies\RolePolicy::class,
        Models\Departement::class => Policies\DepartementPolicy::class,
        Models\Position::class => Policies\PositionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Disable passport routes
        // Passport::routes();

        Passport::tokensCan([
            'primary_account_information' => 'Informasi akun utama seperti nama, username, dan alamat surel.'
        ]);
    }
}
