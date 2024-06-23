<?php

namespace Modules\Core\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Account\Models\User;
use Modules\Core\Policies;
use Modules\Core\Models;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Models\Contract::class => Policies\ContractPolicy::class,
        Models\Departement::class => Policies\DepartementPolicy::class,
        Models\Level::class => Policies\LevelPolicy::class,
        Models\Member::class => Policies\MemberPolicy::class,
        Models\MemberLevel::class => Policies\MemberLevelPolicy::class,
        Models\MemberAchievement::class => Policies\MemberAchievementPolicy::class,
        Models\Manager::class => Policies\ManagerPolicy::class,
        Models\ManagerContract::class => Policies\ManagerContractPolicy::class,
        Models\Position::class => Policies\PositionPolicy::class,
        Models\Unit::class => Policies\UnitPolicy::class,
        Models\UnitDepartement::class => Policies\UnitDepartementPolicy::class,
        Models\UnitPosition::class => Policies\UnitPositionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'core::access',
            fn (User $user) => count(array_filter(array_map(fn ($policy) => (new $policy())->access($user), $this->policies)))
        );
    }
}
