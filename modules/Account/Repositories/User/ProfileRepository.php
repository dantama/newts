<?php

namespace Modules\Account\Repositories\User;

use Auth;
use Illuminate\Support\Arr;
use Modules\Account\Models\User;

trait ProfileRepository
{
    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(User $user, array $array)
    {
        $user->fill(Arr::only($array, ['name', 'email_address']));

        if ($user->save()) {

            $user->setManyMeta($array['meta']);

            Auth::user()->log('update user profile information ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

            return $user;
        }

        return false;
    }
}
