<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\MemberPosition;

class MemberPositionPolicy
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
        return $user->hasAnyPermissionsTo(['read-member-positions', 'write-member-positions', 'delete-member-positions']);
    }

    /**
     * Can show.
     */
    public function show(User $user, MemberPosition $model)
    {
        return $user->hasAnyPermissionsTo(['read-member-positions']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-member-positions']);
    }

    /**
     * Can update.
     */
    public function update(User $user, MemberPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-positions']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, MemberPosition $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-positions']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, MemberPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-positions']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, MemberPosition $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-positions']);
    }
}
