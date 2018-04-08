@extends('layouts.admin.adminMaster')

@section('title', 'IPL-Cibersegurança | Administração')

@section('content')
    <router-view></router-view>
@endsection

@section('pagescript')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-charts.min.js') }}"></script>
    <script src="{{ asset('js/adminVue.js') }}"></script>
@stop