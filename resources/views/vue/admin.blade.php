@extends('layouts.admin.adminMaster')

@section('title', 'IPLeiria Cibersegurança | Administração')

@section('content')
<admin-layout></admin-layout>
@endsection

@section('pagescript')
    
    <!-- Não funciona bem com esta biblioteca -->
    <script src="{{ asset('js/adminVue.js') }}"></script>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <!--<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>-->
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!--<script src="{{ asset('js/charts-home.js') }}"></script>-->
    <script src="{{ asset('js/front.js') }}"></script>
@stop