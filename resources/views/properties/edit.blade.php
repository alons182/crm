@extends('layouts.template')
@section('css')
    <!--<link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">-->
	 <link rel="stylesheet" href="/vendor/classic.css">
	<link rel="stylesheet" href="/vendor/classic.date.css">

@stop
@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Propiedades'])
	
	{!! Form::model($property, ['method' => 'put', 'route' => ['properties.update', $property->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('properties/partials/_form', ['buttonText' => 'Actualizar Propiedad'])
	 
	{!! Form::close() !!}
    @include('sellers/partials/_modal')
@endsection
@section('scripts')
<script src="/vendor/jquery.maskedinput.min.js"></script>
<script src="/vendor/picker.js"></script>
<script src="/vendor/picker.date.js"></script>
<script type="text/javascript">
	
	$("#owner_phone1").mask("9999-9999");
	$("#owner_phone2").mask("9999-9999");
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



