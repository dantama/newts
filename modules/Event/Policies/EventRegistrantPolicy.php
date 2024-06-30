<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\EventRegistrant;

class EventRegistrantPolicy
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
        return $user->hasAnyPermissionsTo(['read-event-registrants', 'write-event-registrants', 'delete-event-registrants']);
    }

    /**
     * Can show.
     */
    public function show(User $user, EventRegistrant $model)
    {
        return $user->hasAnyPermissionsTo(['read-event-registrants']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-event-registrants']);
    }

    /**
     * Can update.
     */
    public function update(User $user, EventRegistrant $model)
    {
        return $user->hasAnyPermissionsTo(['write-event-registrants']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, EventRegistrant $model)
    {
        return $user->hasAnyPermissionsTo(['write-event-registrants']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, EventRegistrant $model)
    {
        return $user->hasAnyPermissionsTo(['delete-event-registrants']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, EventRegistrant $model)
    {
        return $user->hasAnyPermissionsTo(['delete-event-registrants']);
    }
}
