<?php

namespace Modules\Blog\Policies;

use Modules\Account\Models\User;
use Modules\Blog\Models\Template;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Can access Template.
     */
    public function access(User $user)
    {
        return $user->hasAnyPermissionsTo(['read-templates', 'write-templates', 'delete-templates']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Template $model)
    {
        return $user->hasAnyPermissionsTo(['read-templates']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-templates']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Template $model)
    {
        return $user->hasAnyPermissionsTo(['write-templates']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Template $model)
    {
        return $user->hasAnyPermissionsTo(['write-templates']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Template $model)
    {
        return $user->hasAnyPermissionsTo(['delete-templates']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Template $model)
    {
        return $user->hasAnyPermissionsTo(['delete-templates']);
    }
}
