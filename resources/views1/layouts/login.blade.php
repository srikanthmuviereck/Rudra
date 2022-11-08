<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Rudra Connect - Login</title>
		<link rel="icon" type="image/x-icon" href="{{ asset('index_img/logo.png') }}">
        @include('includes.header')
        <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    </head>
<body>
    <div id="center-content" >
        @yield('content')
    </div>
    @include('includes.footer')
</body>
</html>
