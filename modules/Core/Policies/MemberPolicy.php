<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Member;

class MemberPolicy
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
        return $user->hasAnyPermissionsTo(['read-members', 'write-members', 'delete-members']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Member $model)
    {
        return $user->hasAnyPermissionsTo(['read-members']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-members']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Member $model)
    {
        return $user->hasAnyPermissionsTo(['write-members']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, Member $model)
    {
        return $user->hasAnyPermissionsTo(['write-members']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Member $model)
    {
        return $user->hasAnyPermissionsTo(['delete-members']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Member $model)
    {
        return $user->hasAnyPermissionsTo(['delete-members']);
    }
}
