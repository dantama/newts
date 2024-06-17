<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\OrganizationDepartement;

class OrganizationDepartementPolicy
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
        return $user->hasAnyPermissionsTo(['read-organization-departements', 'write-organization-departements', 'delete-organization-departements']);
    }

    /**
     * Can show.
     */
    public function show(User $user, OrganizationDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['read-organization-departements']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-organization-departements']);
    }

    /**
     * Can update.
     */
    public function update(User $user, OrganizationDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['write-organization-departements']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, OrganizationDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['write-organization-departements']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, OrganizationDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organization-departements']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, OrganizationDepartement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organization-departements']);
    }
}
