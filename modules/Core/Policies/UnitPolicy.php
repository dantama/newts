<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Unit;

class UnitPolicy
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
        return $user->hasAnyPermissionsTo(['read-units', 'write-units', 'delete-units']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Unit $model)
    {
        return $user->hasAnyPermissionsTo(['read-units']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-units']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Unit $model)
    {
        return $user->hasAnyPermissionsTo(['write-units']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Unit $model)
    {
        return $user->hasAnyPermissionsTo(['write-units']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Unit $model)
    {
        return $user->hasAnyPermissionsTo(['delete-units']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Unit $model)
    {
        return $user->hasAnyPermissionsTo(['delete-units']);
    }
}
