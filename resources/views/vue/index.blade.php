@extends('layouts.public.publicMaster')

@section('title', 'IPL-Cibersegurança | Página Oficial')

@section('content')
	<navbar></navbar>
	<router-view></router-view>
@endsection

@section('pagescript')
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/publicVue.js') }}"></script>
@stop