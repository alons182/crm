@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/default.css">
	<link rel="stylesheet" href="/vendor/default.date.css">
	<link rel="stylesheet" href="/vendor/default.time.css">


@stop
@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Task'])
	
	{!! Form::model($task, ['method' => 'put', 'route' => ['tasks.update', $task->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('tasks/partials/_form', ['buttonText' => 'Update Task'])
	 
	{!! Form::close() !!}
   
@endsection
@section('scripts')
    <script src="/vendor/picker.js"></script>
    <script src="/vendor/picker.date.js"></script>
    <script src="/vendor/picker.time.js"></script>
    <script type="text/javascript">
		/*$('.datepicker').datepicker();*/
		$('.datepicker').pickadate({
	        monthsFull: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
	        monthsShort: ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'],
	        weekdaysFull: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
	        weekdaysShort: ['dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb'],
	        today: 'hoy',
	        clear: 'borrar',
	        close: 'cerrar',
	        firstDay: 1,
	        format: 'yyyy-mm-dd',
	        formatSubmit: 'yyyy-mm-dd'
	    });
	</script>
	
@stop