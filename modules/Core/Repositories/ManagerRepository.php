<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Arr;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Repositories\User\PhoneRepository;
use Modules\Account\Models\User;
use Modules\Core\Models\Manager;

trait ManagerRepository
{
    use UserRepository, PhoneRepository;

    /**
     * Store newly created resource.
     */
    public function storeManager(array $data, User $user)
    {
        $manager = new Manager(Arr::only($data, ['joined_at']));

        if ($user->Manager()->save($manager)) {
            $user->log('menambahkan pengurus baru dengan nama ' . $user->name . ' <strong>[ID: ' . $manager->id . ']</strong>', Manager::class, $manager->id);
            return $manager;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateManager(Manager $manager, array $data, User $user)
    {
        if ($manager->fill(Arr::only($data, ['joined_at', 'permanent_at', 'kd', 'permanent_kd', 'permanent_sk']))->save()) {
            $user->log('memperbarui data karyawan baru dengan nama ' . $manager->user->name . ' <strong>[ID: ' . $manager->id . ']</strong>', Manager::class, $manager->id);
            return $manager;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function destroyManager(Manager $manager, User $user)
    {
        if (!$manager->trashed() && $manager->delete()) {
            $user->log('menghapus karyawan ' . $manager->user->name . ' <strong>[ID: ' . $manager->id . ']</strong>', Manager::class, $manager->id);
            return $manager;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoreManager(Manager $manager, User $user)
    {
        if ($manager->trashed() && $manager->restore()) {
            $user->log('memulihkan karyawan ' . $manager->user->name . ' <strong>[ID: ' . $manager->id . ']</strong>', Manager::class, $manager->id);
            return $manager;
        }
        return false;
    }
}
