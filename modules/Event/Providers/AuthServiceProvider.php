<?php

namespace Modules\Event\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Account\Models\User;
use Modules\Event\Policies;
use Modules\Event\Models;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Models\Cart::class => Policies\CartPolicy::class,
        Models\Event::class => Policies\EventPolicy::class,
        Models\EventRegistrant::class => Policies\EventRegistrantPolicy::class,
        Models\EventType::class => Policies\EventTypePolicy::class,
        Models\Invoice::class => Policies\InvoicePolicy::class,
        Models\InvoiceItem::class => Policies\InvoiceItemPolicy::class,
        Models\InvoiceTransaction::class => Policies\InvoiceTransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'event::access',
            fn (User $user) => count(array_filter(array_map(fn ($policy) => (new $policy())->access($user), $this->policies)))
        );
    }
}
