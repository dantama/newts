<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Arr;
use Modules\Account\Models\User;
use Modules\Core\Models\Departement;

trait OrganizationDepartmentRepository
{
    /**
     * Define the form keys for resource
     */
    private $keys = [
        'kd', 'name', 'description', 'parent_id', 'is_visible'
    ];

    /**
     * Store newly created resource.
     */
    public function storeCompanyDepartment(array $data, User $user)
    {
        $department = new Departement(Arr::only($data, $this->keys));
        if ($department->save()) {
            $user->log('membuat departemen baru ' . $department->name . ' <strong>[ID: ' . $department->id . ']</strong>', Departement::class, $department->id);
            return $department;
        }
        return false;
    }

    /**
     * Update the current resource.
     */
    public function updateCompanyDepartment(Departement $department, array $data, User $user)
    {
        $department = $department->fill(Arr::only($data, $this->keys));
        if ($department->save()) {
            $user->log('memperbarui departemen ' . $department->name . ' <strong>[ID: ' . $department->id . ']</strong>', Departement::class, $department->id);
            return $department;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function destroyCompanyDepartment(Departement $department, User $user)
    {
        if (!$department->trashed() && $department->delete()) {
            $user->log('menghapus departemen ' . $department->name . ' <strong>[ID: ' . $department->id . ']</strong>', Departement::class, $department->id);
            return $department;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoreCompanyDepartment(Departement $department, User $user)
    {
        if ($department->trashed() && $department->restore()) {
            $user->log('memulihkan departemen ' . $department->name . ' <strong>[ID: ' . $department->id . ']</strong>', Departement::class, $department->id);
            return $department;
        }
        return false;
    }
}
