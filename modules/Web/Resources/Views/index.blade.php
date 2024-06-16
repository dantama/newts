@extends('layouts.default')

@section('title', 'Welcome to ')

@section('bodyclass', 'min-vh-100 d-flex align-items-center')

@section('main')
    <div class="container text-center">
        <div class="d-flex justify-content-center mb-0">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_u13rakf7.json" class="mt-n5" background="transparent" speed="1" style="width: 600px; height: 400px;" loop autoplay></lottie-player>
        </div>
        <div class="h1 fw-bold mb-4">Tungguin ya ...</div>
        <div class="lead text-muted">Kami sedang memeriksa browser kamu sebelum masuk ke <a href="{{ route('account::home') }}">Tapaksuci Apps</a> dalam <span id="timer">3</span> detik</div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            let sec = 3;
            let timer = setInterval(() => {
                sec--;
                document.getElementById('timer').innerHTML = sec;
                if (sec < 1) {
                    window.location.href = "{{ route('account::home') }}";
                    clearInterval(timer);
                }
            }, 1000);
        });
    </script>
@endpush
