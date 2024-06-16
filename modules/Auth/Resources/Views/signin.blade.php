@extends('auth::layouts.auth')

@section('title', 'Sign in | ')

@section('content')
    <h2>Sign in</h2>
    <p class="{{ request('next', false) ? 'text-danger' : 'text-muted' }} mb-4">Please fill in your account credentials below to continue</p>
    <form class="form-block" action="{{ route('auth::signin', ['next' => request('next')]) }}" method="POST"> @csrf
        <div class="tg-steps-signin-form">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username or email" value="{{ old('username') }}" @if (!old('username')) autofocus @endif required autocomplete="off">
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" @if (old('username')) autofocus @endif required autocomplete="off">
                    <button type="button" class="btn btn-light toggle-password" data-target="password" data-bs-toggle="button" tabindex="-1"><i class="mdi mdi-eye"></i></button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @if (old('remember', 1)) checked @endif>
                <label class="form-check-label" for="remember">Save login session</label>
                <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" title="If unchecked, you'll be automatically logged out after a few minutes of inactivity"></i>
            </div>
        </div>
        @error('username')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="d-flex justify-content-between align-items-center mt-5">
            <button type="submit" class="btn btn-soft-danger px-3">Sign in <i class="mdi mdi-arrow-right ms-1"></i></button>
            <a class="btn btn-link float-right pr-0" href="{{ route('auth::forgot', ['next' => request('next')]) }}">Forgot password?</a>
        </div>
    </form>
    @if (config('modules.auth.signup.enabled'))
        <p class="text-muted mb-0 mt-5">Didn't have an account? <a href="{{ route('auth::signup', ['next' => request('next')]) }}">Create an account</a></p>
    @endif
    @if (config('modules.auth.empower.enabled'))
        <div class="d-flex align-items-center w-100 mb-4 mt-5 gap-4">
            <div class="w-100 border-top"></div>
            <div class="small text-muted">OR</div>
            <div class="w-100 border-top"></div>
        </div>
        @if (env('sso'))
            <a href="{{ route('auth::empower') }}" class="btn btn-outline-secondary d-flex align-items-center w-100 text-dark gap-3 p-3 text-start">
                <img src="{{ asset('img/logo/logo-text.svg') }}" alt="" class="d-block" style="height: 20px;">
                <div class="w-100 text-sm-center">Sign in with Empower Account</div>
            </a>
        @endif
    @endif
@endsection

@if (env('TOURGUIDE_ENABLED'))
    @push('styles')
        <link rel="stylesheet" href="{{ asset('vendor/tourguide/tourguide.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/tourguide/tourguide.min.js') }}"></script>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                document.querySelector('.toggle-password').addEventListener('click', (e) => {
                    var toggle = e.currentTarget.classList.contains('active');
                    document.querySelector('[name="' + e.currentTarget.dataset.target + '"]').type = (toggle ? 'text' : 'password');
                    e.currentTarget.querySelector('.mdi').className = (toggle ? 'mdi mdi-eye-off' : 'mdi mdi-eye');
                })
            });

            const startTourguide = async () => {
                const tourguide = new Tourguide({
                    align: 'top',
                    steps: [{
                        step: 1,
                        selector: '.tg-steps-signin-form',
                        title: 'Informasi kredensial',
                        content: 'Username/surel dan sandi kamu sama dengan akun HRIS kamu, kalau kamu kesulitan, bisa hubungi <a href="skype:live:my1985it?chat">Mas Danang</a> atau <a href="skype:live:.cid.f99015b694466a87?chat">Mas Ridho</a>.'
                    }]
                });
                tourguide.start();
            }

            document.addEventListener('DOMContentLoaded', () => {
                startTourguide();
            })
        </script>
    @endpush
@endif
