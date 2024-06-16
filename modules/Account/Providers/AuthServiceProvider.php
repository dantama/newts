<?php

namespace Modules\Account\Providers;

use Modules\Account\Models;
use Modules\Account\Policies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\User::class => Policies\UserPolicy::class,
        Models\UserLog::class => Policies\UserLogPolicy::class,
        Models\Employee::class => Policies\EmployeePolicy::class,
        Models\EmployeeContract::class => Policies\EmployeeContractPolicy::class,
        Models\EmployeePosition::class => Policies\EmployeePositionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
