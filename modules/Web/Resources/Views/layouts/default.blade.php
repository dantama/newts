@extends('layouts.webdefault')

@section('titleTemplate', env('APP_NAME'))

@section('main')
    <main class="main" id="top">
        @include('web::layouts.components.topbar')
        @include('web::layouts.components.navbar')
        @yield('content')
        @include('web::layouts.components.footer')
    </main>
@endsection
