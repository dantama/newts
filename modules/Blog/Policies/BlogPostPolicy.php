<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\BlogPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
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
        return $user->hasAnyPermissionsTo(['read-blog-posts', 'write-blog-posts', 'delete-blog-posts']);
    }

    /**
     * Can show.
     */
    public function show(User $user, BlogPost $model)
    {
        return $user->hasAnyPermissionsTo(['read-blog-posts']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-blog-posts']);
    }

    /**
     * Can update.
     */
    public function update(User $user, BlogPost $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-posts']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, BlogPost $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-posts']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, BlogPost $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-posts']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, BlogPost $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-posts']);
    }
}
