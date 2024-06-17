<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\BlogPostTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostTagPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Can access page.
     */
    public function access(User $user)
    {
        return $user->hasAnyPermissionsTo(['read-blog-post-tags', 'write-blog-post-tags', 'delete-blog-post-tags']);
    }

    /**
     * Can show.
     */
    public function show(User $user, BlogPostTag $model)
    {
        return $user->hasAnyPermissionsTo(['read-blog-post-tags']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-tags']);
    }

    /**
     * Can update.
     */
    public function update(User $user, BlogPostTag $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-tags']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, BlogPostTag $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-tags']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, BlogPostTag $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-post-tags']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, BlogPostTag $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-post-tags']);
    }
}
