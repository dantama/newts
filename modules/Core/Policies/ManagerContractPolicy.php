<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\ManagerContract;

class ManagerContractPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Can access page.
     */
    public function access(User $user)
    {
        return $user->hasAnyPermissionsTo(['read-manager-contracts', 'write-manager-contracts', 'delete-manager-contracts']);
    }

    /**
     * Can show.
     */
    public function show(User $user, ManagerContract $model)
    {
        return $user->hasAnyPermissionsTo(['read-manager-contracts']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-manager-contracts']);
    }

    /**
     * Can update.
     */
    public function update(User $user, ManagerContract $model)
    {
        return $user->hasAnyPermissionsTo(['write-manager-contracts']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, ManagerContract $model)
    {
        return $user->hasAnyPermissionsTo(['write-manager-contracts']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, ManagerContract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-manager-contracts']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, ManagerContract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-manager-contracts']);
    }
}
