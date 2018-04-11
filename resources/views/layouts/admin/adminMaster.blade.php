<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <title>@yield('title')</title>
        
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="all,follow">
        
        <!-- CSS-->
        <link href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}" id="theme-stylesheet">

        <!-- Favicon-->
        <link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}">

    </head>
    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        @include('layouts.admin.partials.navbar')
        <div id="admin" class="content-wrapper">
            @yield('content')
            @include('layouts.admin.partials.footer')
        </div>

        @yield('pagescript') 

    </body>
</html> 

    