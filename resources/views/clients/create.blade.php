@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Clients'])

    {!! Form::open(['route'=>'clients.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('clients/partials/_form')

    {!! Form::close() !!}
	@include('clients/partials/_modal')


@endsection
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>
	<script src="/vendor/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">
		$("#ide").mask("999999999");
		$("#phone1").mask("9999-9999");
		$("#phone2").mask("9999-9999");
		$("#phone3").mask("9999-9999");
		$("#phone4").mask("9999-9999");
	</script>
@stop
