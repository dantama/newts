<?php

namespace Modules\Account\Repositories;

use Arr;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Modules\Auth\Events\SignedIn;
use Modules\Account\Models\User;

trait UserRepository
{
	/**
	 * Store newly created resource.
	 */
	public function storeUser(array $data)
	{
		$user = new User(Arr::only($data, ['name', 'email_address', 'password']));
		if ($user->save()) {
			Auth::user()->log('membuat pengguna baru dengan nama ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);
			return $user;
		}
		return false;
	}

	/**
	 * Remove the current resource.
	 */
	public function destroyUser(User $user)
	{
		if (!$user->trashed() && $user->delete()) {
			Auth::user()->log('menghapus pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);
			return $user;
		}
		return false;
	}

	/**
	 * Restore the current resource.
	 */
	public function restoreUser(User $user)
	{
		if ($user->trashed() && $user->restore()) {
			Auth::user()->log('memulihkan pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);
			return $user;
		}
		return false;
	}

	/**
	 * Reset the password for the current user.
	 */
	public function resetPasswordUser(User $user)
	{
		$password = substr(str_shuffle('0123456789ABCDEF'), 0, 6);
		if ($user->fill(compact('password'))->save()) {
			Auth::user()->log('mengatur ulang sandi pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);
			return $password;
		}
		return false;
	}

	/**
	 * Cross login accross user.
	 */
	public function crossLoginUser(Request $request, User $user)
	{
		Auth::user()->log('cross login ke pengguna ' . $user->name . ' <strong>[ID: ' . $user->id . ']</strong>', User::class, $user->id);

		$request->user()->token()->revoke();
		Cache::flush();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		event(new SignedIn((object) ['access_token' => $user->createToken('Cross Login')->accessToken], false));

		return $user;
	}
}
