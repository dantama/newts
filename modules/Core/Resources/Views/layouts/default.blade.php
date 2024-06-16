@extends('layouts.default')

@section('titleTemplate', config('modules.core.titleTemplate'))

@section('bodyclass', 'bg-light')

@section('main')
    <div class="d-xl-flex min-vh-100 flex-row">
        @include('core::layouts.components.sidebar')
        <div class="content flex-grow-1">
            @include('core::layouts.components.navbar')
            <div class="container-fluid p-3">
                <main class="animate__animated animate__fadeIn animate__faster">
                    <x-alert-success></x-alert-success>
                    <x-alert-danger></x-alert-danger>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
@endsection
