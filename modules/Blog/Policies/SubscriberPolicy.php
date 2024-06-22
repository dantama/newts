<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\Subscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriberPolicy
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
        return $user->hasAnyPermissionsTo(['read-subscribers', 'write-subscribers', 'delete-subscribers']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Subscriber $model)
    {
        return $user->hasAnyPermissionsTo(['read-subscribers']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-subscribers']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Subscriber $model)
    {
        return $user->hasAnyPermissionsTo(['write-subscribers']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Subscriber $model)
    {
        return $user->hasAnyPermissionsTo(['write-subscribers']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Subscriber $model)
    {
        return $user->hasAnyPermissionsTo(['delete-subscribers']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Subscriber $model)
    {
        return $user->hasAnyPermissionsTo(['delete-subscribers']);
    }
}
