<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Arr;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Repositories\User\PhoneRepository;
use Modules\Account\Models\Employee;
use Modules\Account\Models\User;

trait MemberRepository
{
    use UserRepository, PhoneRepository;

    /**
     * Store newly created resource.
     */
    public function storeEmployee(array $data, User $user)
    {
        $user = $this->storeUser(Arr::only($data, ['name', 'username', 'password']));
        $this->updatePhone($user, Arr::only($data, ['phone_code', 'phone_number', 'phone_whatsapp']));

        $employee = new Employee(Arr::only($data, ['joined_at']));

        if ($user->employee()->save($employee)) {
            $user->log('menambahkan karyawan baru dengan nama ' . $user->name . ' <strong>[ID: ' . $employee->id . ']</strong>', Employee::class, $employee->id);
            return $employee;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployee(Employee $employee, array $data, User $user)
    {
        if ($employee->fill(Arr::only($data, ['joined_at', 'permanent_at', 'kd', 'permanent_kd', 'permanent_sk']))->save()) {
            $user->log('memperbarui data karyawan baru dengan nama ' . $employee->user->name . ' <strong>[ID: ' . $employee->id . ']</strong>', Employee::class, $employee->id);
            return $employee;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function destroyEmployee(Employee $employee, User $user)
    {
        if (!$employee->trashed() && $employee->delete()) {
            $user->log('menghapus karyawan ' . $employee->user->name . ' <strong>[ID: ' . $employee->id . ']</strong>', Employee::class, $employee->id);
            return $employee;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoreEmployee(Employee $employee, User $user)
    {
        if ($employee->trashed() && $employee->restore()) {
            $user->log('memulihkan karyawan ' . $employee->user->name . ' <strong>[ID: ' . $employee->id . ']</strong>', Employee::class, $employee->id);
            return $employee;
        }
        return false;
    }
}
