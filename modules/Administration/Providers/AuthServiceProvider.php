<?php

namespace Modules\Administration\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Account\Models\User;
use Modules\Account\Policies as AccountPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        AccountPolicy\UserPolicy::class,
        AccountPolicy\UserLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'administration::access',
            fn (User $user) => count(array_filter(array_map(fn ($policy) => (new $policy())->access($user), $this->policies)))
        );
    }
}
