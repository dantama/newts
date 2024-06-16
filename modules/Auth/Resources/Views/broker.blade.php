@extends('auth::layouts.auth')

@section('title', 'Reset password | ')

@section('content')
    <h2>Reset password</h2>
    <p class="text-muted mb-4">Please remember your password carefully!</p>
    <form class="form-block" action="{{ route('auth::broker') }}" method="POST"> @csrf @method('PATCH')
        <input type="hidden" name="email" value="{{ request('email') }}">
        <input type="hidden" name="token" value="{{ request('token') }}">
        <div class="mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autofocus>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Confirm password" required>
        </div>
        @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <p class="text-muted">Use at least 8 characters. Don't use a password from another site or something easy to guess like your birthday.</p>
        <div class="mt-5">
            <button type="submit" class="btn btn-danger px-3"><i class="mdi mdi-check"></i> Update password</button>
        </div>
    </form>
@endsection
