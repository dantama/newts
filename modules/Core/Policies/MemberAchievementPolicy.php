<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\MemberAchievement;

class MemberAchievementPolicy
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
        return $user->hasAnyPermissionsTo(['read-member-achievements', 'write-member-achievements', 'delete-member-achievements']);
    }

    /**
     * Can show.
     */
    public function show(User $user, MemberAchievement $model)
    {
        return $user->hasAnyPermissionsTo(['read-member-achievements']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-member-achievements']);
    }

    /**
     * Can update.
     */
    public function update(User $user, MemberAchievement $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-achievements']);
    }


    /**
     * Can destroy.
     */
    public function destroy(User $user, MemberAchievement $model)
    {
        return $user->hasAnyPermissionsTo(['write-member-achievements']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, MemberAchievement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-achievements']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, MemberAchievement $model)
    {
        return $user->hasAnyPermissionsTo(['delete-member-achievements']);
    }
}
