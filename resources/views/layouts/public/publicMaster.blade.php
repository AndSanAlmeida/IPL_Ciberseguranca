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

        <!--Main css-->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Caesar+Dressing|Montserrat:400,700|Open+Sans|Righteous" rel="stylesheet">
    </head>
    <body>
        
        <div id="app">
            @yield('content')
        </div> 

        @yield('pagescript')         
    </body>
</html>