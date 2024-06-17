<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Blog\Models\BlogCategory;

class BlogCategoryPolicy
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
        return $user->hasAnyPermissionsTo(['read-blog-categories', 'write-blog-categories', 'delete-blog-categories']);
    }

    /**
     * Can show.
     */
    public function show(User $user, BlogCategory $model)
    {
        return $user->hasAnyPermissionsTo(['read-blog-categories']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-blog-categories']);
    }

    /**
     * Can update.
     */
    public function update(User $user, BlogCategory $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-categories']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, BlogCategory $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-categories']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, BlogCategory $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-categories']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, BlogCategory $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-categories']);
    }
}
