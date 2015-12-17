@extends('templates.template')

@section('content')
 @include('templates/partials/_breadcumbs', ['page' => 'Clients'])
	
	{!! Form::model($client, ['method' => 'put', 'route' => ['clients.update', $client->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('clients/partials/_form', ['buttonText' => 'Update Client'])
	 
	{!! Form::close() !!}
    @include('clients/partials/_modal')
@endsection
