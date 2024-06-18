<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\UnitPosition;

class UnitPositionPolicy
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
        return $user->hasAnyPermissionsTo(['read-unit-positions', 'write-unit-positions', 'delete-unit-positions']);
    }

    /**
     * Can show.
     */
    public function show(User $user, UnitPosition $model)
    {
        return $user->hasAnyPermissionsTo(['read-unit-positions']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-unit-positions']);
    }

    /**
     * Can update.
     */
    public function update(User $user, UnitPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-unit-positions']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, UnitPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-unit-positions']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, UnitPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-unit-positions']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, UnitPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-unit-positions']);
    }
}
