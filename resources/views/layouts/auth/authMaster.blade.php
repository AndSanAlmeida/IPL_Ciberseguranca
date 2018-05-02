<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Bootstrap -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}"  rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
        
        <!-- Styles -->
        <link href="{{ URL::asset('css/auth.css') }}" rel="stylesheet">

        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}">

    </head>
    <body>
        
        <div class="container" id="auth">
            @yield('content')
        </div> 

        @yield('pagescript')         
    </body>
</html>