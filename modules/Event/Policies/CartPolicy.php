<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\Cart;

class CartPolicy
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
        return $user->hasAnyPermissionsTo(['read-carts', 'write-carts', 'delete-carts']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Cart $model)
    {
        return $user->hasAnyPermissionsTo(['read-carts']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-carts']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Cart $model)
    {
        return $user->hasAnyPermissionsTo(['write-carts']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Cart $model)
    {
        return $user->hasAnyPermissionsTo(['write-carts']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Cart $model)
    {
        return $user->hasAnyPermissionsTo(['delete-carts']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Cart $model)
    {
        return $user->hasAnyPermissionsTo(['delete-carts']);
    }
}
