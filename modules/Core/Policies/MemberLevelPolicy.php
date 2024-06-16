<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\MemberLevel;

class MemberLevelPolicy
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
        return $user->hasAnyPermissionsTo(['read-member-levels', 'write-member-levels', 'delete-member-levels']);
    }

    /**
     * Can show.
     */
    public function show(User $user, MemberLevel $model)
    {
        return $user->hasAnyPermissionsTo(['read-member-levels']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-member-levels']);
    }

    /**
     * Can update.
     */
    public function update(User $user, MemberLevel $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-levels']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, MemberLevel $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-levels']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, MemberLevel $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-levels']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, MemberLevel $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-levels']);
    }
}
