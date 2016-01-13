@extends('layouts.template')

@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Task'])
	
	{!! Form::model($task, ['method' => 'put', 'route' => ['tasks.update', $task->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('tasks/partials/_form', ['buttonText' => 'Update Task'])
	 
	{!! Form::close() !!}
   
@endsection
