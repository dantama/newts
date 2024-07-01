<?php

namespace Modules\Blog\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Account\Models\User;
use Modules\Blog\Policies;
use Modules\Blog\Models;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [
        Models\BlogPost::class => Policies\BlogPostPolicy::class,
        Models\BlogCategory::class => Policies\BlogCategoryPolicy::class,
        Models\BlogPostComment::class => Policies\BlogPostCommentPolicy::class,
        Models\BlogPostTag::class => Policies\BlogPostTagPolicy::class,
        Models\Subscriber::class => Policies\SubscriberPolicy::class,
        Models\Testimony::class => Policies\TestimonyPolicy::class,
        Models\Template::class => Policies\TemplatePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(
            'blog::access',
            fn (User $user) => count(array_filter(array_map(fn ($policy) => (new $policy())->access($user), $this->policies)))
        );
    }
}
