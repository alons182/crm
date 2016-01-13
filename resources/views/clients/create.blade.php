@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Clients'])

    {!! Form::open(['route'=>'clients.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('clients/partials/_form')

    {!! Form::close() !!}
	@include('clients/partials/_modal')


@endsection
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>

@stop
