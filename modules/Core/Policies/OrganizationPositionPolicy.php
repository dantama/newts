<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\OrganizationPosition;

class OrganizationPositionPolicy
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
        return $user->hasAnyPermissionsTo(['read-organization-positions', 'write-organization-positions', 'delete-organization-positions']);
    }

    /**
     * Can show.
     */
    public function show(User $user, OrganizationPosition $model)
    {
        return $user->hasAnyPermissionsTo(['read-organization-positions']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-organization-positions']);
    }

    /**
     * Can update.
     */
    public function update(User $user, OrganizationPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-organization-positions']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, OrganizationPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-organization-positions']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, OrganizationPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organization-positions']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, OrganizationPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organization-positions']);
    }
}
