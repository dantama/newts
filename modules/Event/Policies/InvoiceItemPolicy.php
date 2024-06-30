<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\InvoiceItem;

class InvoiceItemPolicy
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
        return $user->hasAnyPermissionsTo(['read-invoice-items', 'write-invoice-items', 'delete-invoice-items']);
    }

    /**
     * Can show.
     */
    public function show(User $user, InvoiceItem $model)
    {
        return $user->hasAnyPermissionsTo(['read-invoice-items']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-items']);
    }

    /**
     * Can update.
     */
    public function update(User $user, InvoiceItem $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-items']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, InvoiceItem $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-items']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, InvoiceItem $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoice-items']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, InvoiceItem $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoice-items']);
    }
}
