<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="This is RestodayBar">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'LaraPort') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/logo.svg') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('vendors-style')

</head>
<body>
    <div id="app" class="d-flex">
        <x-organisms.sidebar />
        
        <main class="vh-100">
            <x-organisms.header />

            <x-molecules.breadcrumb 
                :title="$title"
                :breadcrumbs="$breadcrumbs" />

            @yield('content')

            <br>

            <!-- <x-organisms.footer /> -->
        </main>
    </div>

    @yield('vendors-script')

    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

    @yield('scripts')
    @yield('script-src')
</body>
</html>
