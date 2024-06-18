<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\UnitDepartement;

class UnitDepartementPolicy
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
        return $user->hasAnyPermissionsTo(['read-unit-departements', 'write-unit-departements', 'delete-unit-departements']);
    }

    /**
     * Can show.
     */
    public function show(User $user, UnitDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['read-unit-departements']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-unit-departements']);
    }

    /**
     * Can update.
     */
    public function update(User $user, UnitDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['write-unit-departements']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, UnitDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['write-unit-departements']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, UnitDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-unit-departements']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, UnitDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-unit-departements']);
    }
}
