@extends('templates.template')


@section('content')

 @include('templates/partials/_breadcumbs', ['page' => 'Clients'])

    {!! Form::open(['route'=>'clients.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('clients/partials/_form')

    {!! Form::close() !!}
	@include('clients/partials/_modal')


@endsection

