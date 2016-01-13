@extends('layouts.template')


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Properties'])

    {!! Form::open(['route'=>'properties.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('properties/partials/_form')

    {!! Form::close() !!}
	@include('sellers/partials/_modal')


@endsection

