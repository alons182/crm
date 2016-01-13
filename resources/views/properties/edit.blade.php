@extends('layouts.template')

@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Properties'])
	
	{!! Form::model($property, ['method' => 'put', 'route' => ['properties.update', $property->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('properties/partials/_form', ['buttonText' => 'Update Property'])
	 
	{!! Form::close() !!}
    @include('sellers/partials/_modal')
@endsection



