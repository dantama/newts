<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ app()->getLocale() }}" />
    <meta name='keywords' content="@yield('meta_keywords', config('app.settings.meta_keywords', 'website'))" />
    <meta name='geo.placename' content='Indonesia' />
    <meta name='audience' content='all' />
    <meta name='rating' content='general' />
    <meta name='author' content="@yield('meta_author', config('app.settings.meta_author', config('app.name')))" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="@yield('meta_url', url()->current())" />
    <meta property="og:title" content="@yield('title'){{ config('app.settings.app_name', config('app.name')) }}" />
    <meta property="og:image" content="@yield('meta_image', asset(config('app.settings.meta_image', 'img/logo/logo-text-sq-512.png')))" />
    <meta property="og:description" content="@yield('meta_description', config('app.settings.meta_description', config('app.url')))" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
    <link href="{{ asset(mix('css/styles.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset(mix('vendor/@mdi/css/materialdesignicons.min.css')) }}" rel="stylesheet">
    <link rel="manifest" href="{{ asset('/manifest.json') }}" />
    <!-- ios support -->
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-72.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-96.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-128.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-144.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-152.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-192.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-384.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/logo/logo-icon-bw-512.png') }}" />
    <meta name="apple-mobile-web-app-status-bar" content="#fc0f03" />
    <meta name="theme-color" content="#fc0f03" />
    <title>@yield('title') @yield('titleTemplate', config('app.settings.app_name', config('app.name', 'Laravel')))</title>
    @livewireStyles
    @auth
        <meta name="oauth-token" content="{{ json_decode(Cookie::get(config('auth.cookie')))->access_token }}" />
    @endauth
    @stack('styles')
</head>

<body class="@yield('bodyclass')">

    @auth
        @if (Route::has(config('modules.auth.signout.route')))
            <script>
                const signout = (e) => {
                    if (confirm('Apakah Anda yakin?')) {
                        document.getElementById('signout-form').submit();
                    }
                }
            </script>
            <form class="form-block form-confirm" id="signout-form" action="{{ route(config('modules.auth.signout.route')) }}" method="POST" style="display: none;"> @csrf </form>
        @endif
    @endauth

    @yield('main')

    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts.js')) }}"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
