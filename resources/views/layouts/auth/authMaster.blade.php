<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        
        <!-- Bootstrap -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}"  rel="stylesheet">
        <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
        
        <!-- Styles -->
        <link href="{{ URL::asset('css/auth.css') }}" rel="stylesheet">

    </head>
    <body>
        
        <div class="container" id="auth">
            @yield('content')
        </div> 

        @yield('pagescript')         
    </body>
</html>