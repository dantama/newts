@extends('layouts.default')

@section('titleTemplate', config('modules.blog.titleTemplate'))

@section('bodyclass', 'bg-light')

@section('main')
    <div class="d-xl-flex min-vh-100 flex-row">
        @include('event::layouts.components.sidebar')
        <div class="content d-flex flex-grow-1 flex-column" style="min-height: 100vh;">
            @include('event::layouts.components.navbar')
            <div class="container-fluid flex-grow-1 p-3">
                <main class="animate__animated animate__fadeIn animate__faster">
                    <x-alert-success></x-alert-success>
                    <x-alert-danger></x-alert-danger>
                    @yield('content')
                </main>
            </div>
            <footer>
                <div class="text-muted bg-white py-3">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-md-0 mb-1">
                                <div class="text-md-start text-center">{{ env('APP_NAME') }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end text-center">Copyright &copy; 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
