<?php

namespace Modules\Core\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\Level;

class LevelPolicy
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
        return $user->hasAnyPermissionsTo(['read-levels', 'write-levels', 'delete-levels']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Level $model)
    {
        return $user->hasAnyPermissionsTo(['read-levels']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-levels']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Level $model)
    {
        return $user->hasAnyPermissionsTo(['write-levels']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Level $model)
    {
        return $user->hasAnyPermissionsTo(['write-levels']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Level $model)
    {
        return $user->hasAnyPermissionsTo(['delete-levels']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Level $model)
    {
        return $user->hasAnyPermissionsTo(['delete-levels']);
    }
}
