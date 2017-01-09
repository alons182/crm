@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/chosen.min.css">
    <link rel="stylesheet" href="/vendor/classic.css">
	<link rel="stylesheet" href="/vendor/classic.date.css">
    <!--<link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">-->

@stop

@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Clientes'])

    {!! Form::open(['route'=>'clients.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('clients/partials/_form')

    {!! Form::close() !!}
	@include('clients/partials/_modal')


@endsection
@section('scripts')
    <!--<script src="/vendor/bootstrap-select/bootstrap-select.js"></script>-->
    <script src="/vendor/chosen.jquery.min.js"></script>
	<script src="/vendor/jquery.maskedinput.min.js"></script>
	<script src="/vendor/picker.js"></script>
    <script src="/vendor/picker.date.js"></script>
	<script type="text/javascript">
		$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
		$("#ide").mask("999999999");
		$("#phone1").mask("9999-9999");
		$("#phone2").mask("9999-9999");
		$("#phone3").mask("9999-9999");
		$("#phone4").mask("9999-9999");

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

