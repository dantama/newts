<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\Invoice;

class InvoicePolicy
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
        return $user->hasAnyPermissionsTo(['read-invoices', 'write-invoices', 'delete-invoices']);
    }

    /**
     * Can show.
     */
    public function show(User $user, Invoice $model)
    {
        return $user->hasAnyPermissionsTo(['read-invoices']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-invoices']);
    }

    /**
     * Can update.
     */
    public function update(User $user, Invoice $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoices']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, Invoice $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoices']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, Invoice $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoices']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, Invoice $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoices']);
    }
}
