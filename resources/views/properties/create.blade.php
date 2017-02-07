@extends('layouts.template')

<link rel="stylesheet" href="/vendor/classic.css">
<link rel="stylesheet" href="/vendor/classic.date.css">

@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Propiedades'])

    {!! Form::open(['route'=>'properties.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('properties/partials/_form')

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
