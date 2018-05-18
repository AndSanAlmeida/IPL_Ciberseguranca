@extends('layouts.admin.adminMaster')

@section('title', 'IPL-Cibersegurança | Administração')

@section('content')
    <navbar-top></navbar-top>
    <div class="page-content d-flex align-items-stretch">
        <navbar-left></navbar-left>
        <div class="content-inner">
            <router-view></router-view>
            <admin-footer></admin-footer>
        </div>
    </div> 
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