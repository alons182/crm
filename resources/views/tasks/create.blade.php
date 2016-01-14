@extends('layouts.template')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-datepicker/datepicker.css">

@stop


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Tasks'])

    {!! Form::open(['route'=>'tasks.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('tasks/partials/_form')

    {!! Form::close() !!}
	


@endsection
@section('scripts')
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$('.datepicker').datepicker();
	</script>
@stop

