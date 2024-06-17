<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Manager;

class ManagerPolicy
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
        return $user->hasAnyPermissionsTo(['read-managers', 'write-managers', 'delete-managers']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Manager $model)
    {
        return $user->hasAnyPermissionsTo(['read-managers']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-managers']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Manager $model)
    {
        return $user->hasAnyPermissionsTo(['write-managers']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Manager $model)
    {
        return $user->hasAnyPermissionsTo(['write-managers']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Manager $model)
    {
        return $user->hasAnyPermissionsTo(['delete-managers']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Manager $model)
    {
        return $user->hasAnyPermissionsTo(['delete-managers']);
    }
}
