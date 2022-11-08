<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		
		<title>Rudra Connect - Admin</title>
		<link rel="icon" type="image/x-icon" href="{{ asset('index_img/logo.png') }}">
        
        @include('includes.header')
        @powerGridStyles
        <link href="{{ asset('css/menu.css') }}" rel="stylesheet" />
    </head>
<body>
    @include('includes.menu')

    @include('includes.footer')
    {{-------powergrid start---------}}
    <script src="{{ asset('js/bootstrap5-bundle.js') }}"></script>
    <script src="{{ asset('js/slim.min.js') }}"></script>
    @powerGridScripts

    @stack('scripts')
    {{-------powergrid end---------}}

    <script src="{{ asset('js/bootstrap-bundle-min.js') }}"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    
</body>
</html>
