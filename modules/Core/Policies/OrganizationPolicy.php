<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Organization;

class OrganizationPolicy
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
        return $user->hasAnyPermissionsTo(['read-organizations', 'write-organizations', 'delete-organizations']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Organization $model)
    {
        return $user->hasAnyPermissionsTo(['read-organizations']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-organizations']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Organization $model)
    {
        return $user->hasAnyPermissionsTo(['write-organizations']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Organization $model)
    {
        return $user->hasAnyPermissionsTo(['write-organizations']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Organization $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organizations']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Organization $model)
    {
        return $user->hasAnyPermissionsTo(['delete-organizations']);
    }
}
