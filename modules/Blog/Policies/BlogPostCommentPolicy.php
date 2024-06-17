<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\BlogPostComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostCommentPolicy
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
        return $user->hasAnyPermissionsTo(['read-blog-post-comments', 'write-blog-post-comments', 'delete-blog-post-comments']);
    }

    /**
     * Can show.
     */
    public function show(User $user, BlogPostComment $model)
    {
        return $user->hasAnyPermissionsTo(['read-blog-post-comments']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-comments']);
    }

    /**
     * Can update.
     */
    public function update(User $user, BlogPostComment $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-comments']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, BlogPostComment $model)
    {
        return $user->hasAnyPermissionsTo(['write-blog-post-comments']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, BlogPostComment $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-post-comments']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, BlogPostComment $model)
    {
        return $user->hasAnyPermissionsTo(['delete-blog-post-comments']);
    }
}
