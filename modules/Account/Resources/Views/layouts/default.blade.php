@extends('layouts.default')
@section('titleTemplate', config('modules.account.name'))
@section('bodyclass', 'd-flex flex-column justify-content-between min-vh-100 bg-light')

@section('main')
    <div>
        @include('account::layouts.components.navbar')
        <div id="app" class="py-sm-4 py-3">
            <main class="main">
                @include('account::layouts.components.sidebar')
                <div class="container-lg">
                    <x-alert-success></x-alert-success>
                    <x-alert-danger></x-alert-danger>
                    <div class="card d-flex flex-md-row mb-5 rounded border-0 bg-white">
                        <div class="card-body" class="flex-grow-1">
                            <div class="animate__animated animate__fadeIn animate__faster">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0 mt-4 text-center">Only you can access this page, we are committed to protecting your privacy.</p>
                </div>
            </main>
        </div>
    </div>
@endsection
