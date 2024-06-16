@extends('account::layouts.default')

@section('title', 'Change password | ')

@php($user = Auth::user())

@section('content')
    <div class="card card-body d-flex flex-sm-row align-items-center gap-sm-4 rounded border-0 p-4" style="background: linear-gradient(to bottom, #fcf1f1, transparent);">
        <i class="mdi mdi-lock-open-outline mdi-48px text-danger mx-2"></i>
        <div class="text-sm-start text-center">
            <h2 class="mb-1">Change password</h2>
            <div class="text-muted">You can change your password for security reasons or reset it if you forget it.</div>
        </div>
    </div>
    @if (is_null($user->password) && $user->email_verified_at)
        <form class="form-block" method="post" action="{{ route('account::user.password.reset', ['next' => route('account::home')]) }}"> @csrf
            <div class="alert alert-warning text-danger border-0" role="alert">
                It seems, you haven't created a password because you logged in via platform, try clicking <button class="btn btn-link mt-n1 p-0"><u>reset password</u></button> from your verified email.
            </div>
        </form>
    @endif
    <div class="card card-body bg-light border-0 p-4">
        <form class="form-block" action="{{ route('account::user.password', ['next' => request('next')]) }}" method="POST"> @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label required">Current password</label>
                <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>
                @error('old_password')
                    <small class="text-danger d-block"> {{ $message }} </small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label required">New password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                <small class="form-text text-muted">Use at least 8 characters. Don't use a password from another site or something easy to guess like your birthday.</small>
                <div class="progress my-2" id="password-strength" style="height: 4px;">
                    <div class="progress-bar" role="progressbar"></div>
                </div>
                @error('password')
                    <small class="text-danger d-block"> {{ $message }} </small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label required">Confirm password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
            </div>
            <div>
                <button class="btn btn-soft-danger" type="submit"><i class="mdi mdi-check"></i> Update password</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('[name="password"]').addEventListener('keyup', (e) => {
            const password = e.currentTarget.value;
            const strengthbar = document.getElementById("password-strength");
            let bar = strengthbar.querySelector('.progress-bar');
            var strength = 0;
            if (password.length >= 8) strength += 20;
            if (password.match(/[a-z]+/)) strength += 20;
            if (password.match(/[A-Z]+/)) strength += 20;
            if (password.match(/[0-9]+/)) strength += 20;
            if (password.match(/[$@#&!]+/)) strength += 20;

            bar.classList.toggle('bg-danger', strength < 50);
            bar.classList.toggle('bg-warning', strength < 100);
            bar.classList.toggle('bg-success', strength >= 100);
            bar.style.width = `${strength}%`;
        });
    </script>
@endpush
