<?php

namespace Modules\Event\Policies;

use Modules\Account\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Event\Models\InvoiceTransaction;

class InvoiceTransactionPolicy
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
        return $user->hasAnyPermissionsTo(['read-invoice-transactions', 'write-invoice-transactions', 'delete-invoice-transactions']);
    }

    /**
     * Can show.
     */
    public function show(User $user, InvoiceTransaction $model)
    {
        return $user->hasAnyPermissionsTo(['read-invoice-transactions']);
    }

    /**
     * Can store.
     */
    public function store(User $user)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-transactions']);
    }

    /**
     * Can update.
     */
    public function update(User $user, InvoiceTransaction $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-transactions']);
    }

    /**
     * Can destroy.
     */
    public function destroy(User $user, InvoiceTransaction $model)
    {
        return $user->hasAnyPermissionsTo(['write-invoice-transactions']);
    }

    /**
     * Can restore.
     */
    public function restore(User $user, InvoiceTransaction $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoice-transactions']);
    }

    /**
     * Can kill.
     */
    public function kill(User $user, InvoiceTransaction $model)
    {
        return $user->hasAnyPermissionsTo(['delete-invoice-transactions']);
    }
}
