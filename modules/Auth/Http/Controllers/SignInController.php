<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Events\SignedIn;
use Modules\Auth\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\SignIn\StoreRequest;

class SignInController extends Controller
{
    /**
     * Attempt to authenticate the request's credentials.
     */
    public function store(StoreRequest $request)
    {
        $request->ensureIsNotRateLimited();

        $response = Http::withOptions(['verify' => false])->post(route('passport.token'), $request->transformed());

        if ($response->ok()) {

            RateLimiter::clear($request->throttleKey());

            event(new SignedIn($response->object(), $request->has('remember')));

            return redirect()->intended($request->get('next', route('account::home')));
        }

        RateLimiter::hit($request->throttleKey());

        throw ValidationException::withMessages([
            'username' => $response->object() ? __('auth::signin.' . $response->object()?->error ?? 'invalid_grant') : 'Terjadi kesalahan di sisi server, silahkan hubungi kami.'
        ]);
    }
}
