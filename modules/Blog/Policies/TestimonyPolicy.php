<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\Testimony;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonyPolicy
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
        return $user->hasAnyPermissionsTo(['read-testimonies', 'write-testimonies', 'delete-testimonies']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Testimony $model)
    {
        return $user->hasAnyPermissionsTo(['read-testimonies']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-testimonies']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Testimony $model)
    {
        return $user->hasAnyPermissionsTo(['write-testimonies']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Testimony $model)
    {
        return $user->hasAnyPermissionsTo(['write-testimonies']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Testimony $model)
    {
        return $user->hasAnyPermissionsTo(['delete-testimonies']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Testimony $model)
    {
        return $user->hasAnyPermissionsTo(['delete-testimonies']);
    }
}
