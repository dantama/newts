<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\MemberContract;

class MemberContractPolicy
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
        return $user->hasAnyPermissionsTo(['read-member-contracts', 'write-member-contracts', 'delete-member-contracts']);
    }

    /**
     * Can show.
     */
    public function show(User $user, MemberContract $model)
    {
        return $user->hasAnyPermissionsTo(['read-member-contracts']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-member-contracts']);
    }

    /**
     * Can update.
     */
    public function update(User $user, MemberContract $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-contracts']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, MemberContract $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-contracts']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, MemberContract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-contracts']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, MemberContract $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-contracts']);
    }
}
