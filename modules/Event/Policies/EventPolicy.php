<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\Event;

class EventPolicy
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
        return $user->hasAnyPermissionsTo(['read-events', 'write-events', 'delete-events']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Event $model)
    {
        return $user->hasAnyPermissionsTo(['read-events']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-events']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Event $model)
    {
        return $user->hasAnyPermissionsTo(['write-events']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Event $model)
    {
        return $user->hasAnyPermissionsTo(['write-events']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Event $model)
    {
        return $user->hasAnyPermissionsTo(['delete-events']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Event $model)
    {
        return $user->hasAnyPermissionsTo(['delete-events']);
    }
}
