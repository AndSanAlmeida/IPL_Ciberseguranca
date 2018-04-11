@extends('layouts.auth.authMaster')

@section('title', 'IPL-Cibersegurança | Autenticação')

@section('content')
    <router-view></router-view>
@endsection

@section('pagescript')
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/authVue.js') }}"></script>
@stop