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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&?family=Roboto:wght@300;400;500;600;700;800;900display=swap" rel="stylesheet">
    
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo/favico.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 

    @yield('vendors-style')

</head>
<body>
    <div class="container-fluid" id="auth">
        @yield('auth')
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- VENDORS --}}
    @yield('vendors-script')

    {{-- INLINE SCRIPTS --}}
    @yield('scripts')
</body>
</html>