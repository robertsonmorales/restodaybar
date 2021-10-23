<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Core Framework">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'RestodayBar') }}</title>
        
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.svg') }}">

    <link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-grid.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-theme_material.css') }}">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('vendors-style')

</head>
<body>
    <div id="app" class="d-flex">
        @include('includes.sidebar')
        
        <main class="vh-100">
            @include('includes.header')
            @include('includes.breadcrumb')
            @yield('content')

            <div class="footer mx-4 text-center sticky-bottom">
                <p class="font-size-sm text-muted">All rights reserved 2021, Robertson Morales</p>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendors/ag-grid/ag-grid.js') }}"></script>
    <script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @yield('vendors-script')
    @yield('scripts')
    @yield('script-src')
</body>
</html>
