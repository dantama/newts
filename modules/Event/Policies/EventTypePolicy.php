<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\EventType;

class EventTypePolicy
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
        return $user->hasAnyPermissionsTo(['read-event-types', 'write-event-types', 'delete-event-types']);
    }

    /**
     * Can show.
     */
    public function show(User $user, EventType $model)
    {
        return $user->hasAnyPermissionsTo(['read-event-types']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-event-types']);
    }

    /**
     * Can update.
     */
    public function update(User $user, EventType $model)
    {
        return $user->hasAnyPermissionsTo(['write-event-types']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, EventType $model)
    {
        return $user->hasAnyPermissionsTo(['write-event-types']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, EventType $model)
    {
        return $user->hasAnyPermissionsTo(['delete-event-types']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, EventType $model)
    {
        return $user->hasAnyPermissionsTo(['delete-event-types']);
    }
}
