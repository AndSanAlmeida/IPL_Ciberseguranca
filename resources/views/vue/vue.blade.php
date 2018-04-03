@extends('index')

@section('title', 'Oficina Cibersegurança')

@section('content')
<navbar></navbar>
<router-view></router-view>
@endsection

@section('pagescript')
<script src="js/app.js"></script>
@endsection