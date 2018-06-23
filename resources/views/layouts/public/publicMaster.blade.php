<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
    <head>
        

        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Bootstrap -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}"  rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

        <!--Main css-->
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Caesar+Dressing|Montserrat:400,700|Open+Sans|Righteous" rel="stylesheet">

        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}">
        
        <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
</script>
    </head>
    <body>
        
        <div id="app">
            @yield('content')
        </div>

        @yield('pagescript')         
    </body>
</html>