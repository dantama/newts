@extends('auth::layouts.auth')

@section('title', 'Masuk | ')

@section('content')
    <h2>Masuk</h2>
    <p class="{{ request('next', false) ? 'text-danger' : 'text-muted' }} mb-4">Silakan isi kredensial akun Anda di bawah ini untuk melanjutkan</p>
    <form class="form-block" action="{{ route('auth::signin', ['next' => request('next')]) }}" method="POST"> @csrf
        <div class="tg-steps-signin-form">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username atau email" value="{{ old('username') }}" @if (!old('username')) autofocus @endif required autocomplete="off">
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Sandi" @if (old('username')) autofocus @endif required autocomplete="off">
                    <button type="button" class="btn btn-light toggle-password" data-target="password" data-bs-toggle="button" tabindex="-1"><i class="mdi mdi-eye"></i></button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @if (old('remember', 1)) checked @endif>
                <label class="form-check-label" for="remember">Simpan sesi login</label>
                <i class="mdi mdi-information-outline" data-bs-toggle="tooltip" title="Jika tidak dicentang, Anda akan keluar secara otomatis setelah beberapa menit tidak aktif"></i>
            </div>
        </div>
        @error('username')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        <div class="d-flex justify-content-between align-items-center mt-5">
            <button type="submit" class="btn btn-soft-danger px-3">Masuk <i class="mdi mdi-arrow-right ms-1"></i></button>
            <a class="btn btn-link float-right pr-0" href="{{ route('auth::forgot', ['next' => request('next')]) }}">Lupa sandi?</a>
        </div>
    </form>
    @if (config('modules.auth.signup.enabled'))
        <p class="text-muted mb-0 mt-5">Belum punya akun? <a href="{{ route('auth::signup', ['next' => request('next')]) }}">Buat akun baru</a></p>
    @endif
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            [].slice.call(document.querySelectorAll('.toggle-password')).map((e) => {
                e.addEventListener('click', (e) => {
                    var toggle = e.currentTarget.classList.contains('active');
                    document.querySelector('[name="' + e.currentTarget.dataset.target + '"]').type = (toggle ? 'text' : 'password');
                    e.currentTarget.querySelector('.mdi').className = (toggle ? 'mdi mdi-eye-off' : 'mdi mdi-eye');
                });
            });
        });
    </script>
@endpush
