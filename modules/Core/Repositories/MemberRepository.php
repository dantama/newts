<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Arr;
use Modules\Account\Repositories\UserRepository;
use Modules\Account\Repositories\User\PhoneRepository;
use Modules\Account\Models\User;
use Modules\Core\Models\Member;

trait MemberRepository
{
    use UserRepository, PhoneRepository;

    /**
     * Store newly created resource.
     */
    public function storeMembers(array $data, User $user)
    {
        $user = $this->storeUser(Arr::only($data, ['name', 'username', 'password']));
        $this->updatePhone($user, Arr::only($data, ['phone_code', 'phone_number', 'phone_whatsapp']));

        $member = new Member(Arr::only($data, ['joined_at']));

        if ($user->member()->save($member)) {
            $user->log('menambahkan anggota baru dengan nama ' . $user->name . ' <strong>[ID: ' . $member->id . ']</strong>', member::class, $member->id);
            return $member;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatemember(Member $member, array $data, User $user)
    {
        if ($member->fill(Arr::only($data, ['joined_at', 'permanent_at', 'kd', 'permanent_kd', 'permanent_sk']))->save()) {
            $user->log('memperbarui data karyawan baru dengan nama ' . $member->user->name . ' <strong>[ID: ' . $member->id . ']</strong>', member::class, $member->id);
            return $member;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function destroymember(Member $member, User $user)
    {
        if (!$member->trashed() && $member->delete()) {
            $user->log('menghapus karyawan ' . $member->user->name . ' <strong>[ID: ' . $member->id . ']</strong>', member::class, $member->id);
            return $member;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoremember(Member $member, User $user)
    {
        if ($member->trashed() && $member->restore()) {
            $user->log('memulihkan karyawan ' . $member->user->name . ' <strong>[ID: ' . $member->id . ']</strong>', member::class, $member->id);
            return $member;
        }
        return false;
    }
}
