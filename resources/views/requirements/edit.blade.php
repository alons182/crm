@extends('layouts.template')

@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Requerimiento de Banco'])
	
	{!! Form::model($requirement, ['method' => 'put', 'route' => ['requirements.update', $requirement->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('requirements/partials/_form', ['buttonText' => 'Actualizar Requerimiento'])
	 
	{!! Form::close() !!}
    
@endsection
@section('scripts')

@stop



