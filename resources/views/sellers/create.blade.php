@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Vendedores'])

        {!! Form::open(['route'=>'sellers.store','files'=> true, 'class'=>'form-horizontal']) !!}

            @include('sellers/partials/_form')

        {!! Form::close() !!}
		
		@include('sellers/partials/_modal')
@stop
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>
	
@stop
